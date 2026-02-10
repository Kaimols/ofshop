import bcrypt from "bcryptjs";
import jwt from "jsonwebtoken";

export default async function handler(req, res) {
  try {
    if (req.method !== "POST") {
      return res.status(405).json({ status: "error", message: "Only POST allowed" });
    }

    const { username, password } = req.body || {};
    if (!username || !password) {
      return res.json({ status: "error", message: "Bitte alle Felder ausfüllen." });
    }

    // IMPORTANT: select explizit, sonst debug schwer
    const url =
      `${process.env.SUPABASE_URL}/rest/v1/users` +
      `?select=id,username,password_hash` +
      `&username=eq.${encodeURIComponent(username.trim())}` +
      `&limit=1`;

    const r = await fetch(url, {
      headers: {
        apikey: process.env.SUPABASE_SERVICE_ROLE_KEY,
        Authorization: `Bearer ${process.env.SUPABASE_SERVICE_ROLE_KEY}`,
      },
    });

    const raw = await r.text();

    if (!r.ok) {
      // Supabase Fehlertext direkt zurückgeben (damit du ihn siehst)
      return res.status(500).json({
        status: "error",
        message: "Supabase error",
        detail: raw,
      });
    }

    let users;
    try {
      users = JSON.parse(raw);
    } catch {
      return res.status(500).json({
        status: "error",
        message: "Supabase returned non-JSON",
        detail: raw,
      });
    }

    const user = Array.isArray(users) ? users[0] : null;

    if (!user) {
      return res.json({ status: "error", message: "User nicht gefunden." });
    }

    if (!user.password_hash) {
      return res.status(500).json({
        status: "error",
        message: "User hat kein password_hash",
        detail: user,
      });
    }

    const ok = await bcrypt.compare(password, user.password_hash);
    if (!ok) {
      return res.json({ status: "error", message: "Passwort falsch." });
    }

    if (!process.env.JWT_SECRET) {
      return res.status(500).json({ status: "error", message: "JWT_SECRET fehlt in Vercel Env." });
    }

    const token = jwt.sign(
      { uid: user.id, username: user.username },
      process.env.JWT_SECRET,
      { expiresIn: "7d" }
    );

    res.setHeader(
      "Set-Cookie",
      `session=${token}; Path=/; HttpOnly; Secure; SameSite=Lax; Max-Age=604800`
    );

    return res.json({ status: "success", message: "Login erfolgreich." });
  } catch (e) {
    return res.status(500).json({
      status: "error",
      message: "Server crashed",
      detail: String(e?.message || e),
    });
  }
}