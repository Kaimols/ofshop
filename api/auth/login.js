import bcrypt from "bcryptjs";
import jwt from "jsonwebtoken";

export default async function handler(req, res) {
  if (req.method !== "POST") {
    return res.status(405).json({ status: "error", message: "Only POST allowed" });
  }

  try {
    const { username, password } = req.body || {};

    if (!username || !password) {
      return res.json({ status: "error", message: "Bitte alle Felder ausfüllen." });
    }

    if (!process.env.SUPABASE_URL || !process.env.SUPABASE_SERVICE_ROLE_KEY) {
      return res.status(500).json({ status: "error", message: "Server falsch konfiguriert." });
    }
    if (!process.env.JWT_SECRET) {
      return res.status(500).json({ status: "error", message: "JWT_SECRET fehlt." });
    }

    const u = encodeURIComponent(username.trim());

    // Nur benötigte Felder holen
    const r = await fetch(
      `${process.env.SUPABASE_URL}/rest/v1/users?username=eq.${u}&select=id,username,password_hash`,
      {
        headers: {
          apikey: process.env.SUPABASE_SERVICE_ROLE_KEY,
          Authorization: `Bearer ${process.env.SUPABASE_SERVICE_ROLE_KEY}`,
        },
      }
    );

    if (!r.ok) {
      const txt = await r.text().catch(() => "");
      console.error("Supabase fetch error:", r.status, txt);
      return res.status(500).json({ status: "error", message: "Serverfehler." });
    }

    const users = await r.json();
    const user = users?.[0];

    if (!user?.password_hash) {
      return res.json({ status: "error", message: "Login fehlgeschlagen." });
    }

    const ok = await bcrypt.compare(password, user.password_hash);
    if (!ok) {
      return res.json({ status: "error", message: "Login fehlgeschlagen." });
    }

    // last_login_at updaten (best effort)
    fetch(`${process.env.SUPABASE_URL}/rest/v1/users?id=eq.${user.id}`, {
      method: "PATCH",
      headers: {
        "Content-Type": "application/json",
        apikey: process.env.SUPABASE_SERVICE_ROLE_KEY,
        Authorization: `Bearer ${process.env.SUPABASE_SERVICE_ROLE_KEY}`,
      },
      body: JSON.stringify({ last_login_at: new Date().toISOString() }),
    }).catch(() => {});

    const token = jwt.sign(
      { uid: user.id, username: user.username },
      process.env.JWT_SECRET,
      { expiresIn: "7d" }
    );

    const isProd = process.env.NODE_ENV === "production";
    const cookie =
      `session=${token}; Path=/; HttpOnly; SameSite=Lax; Max-Age=604800` +
      (isProd ? `; Secure` : "");

    res.setHeader("Set-Cookie", cookie);

    return res.json({ status: "success", message: "Login erfolgreich." });
  } catch (err) {
    console.error("Login error:", err);
    return res.status(500).json({ status: "error", message: "Serverfehler." });
  }
}