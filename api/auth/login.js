import bcrypt from "bcryptjs";
import jwt from "jsonwebtoken";

export default async function handler(req, res) {
  if (req.method !== "POST") {
    return res.status(405).json({ status: "error", message: "Only POST allowed" });
  }

  const { username, password } = req.body || {};

  if (!username || !password) {
    return res.json({ status: "error", message: "Bitte alle Felder ausfüllen." });
  }

  const r = await fetch(
    `${process.env.SUPABASE_URL}/rest/v1/users?username=eq.${encodeURIComponent(username)}`,
    {
      headers: {
        "apikey": process.env.SUPABASE_SERVICE_ROLE_KEY,
        "Authorization": `Bearer ${process.env.SUPABASE_SERVICE_ROLE_KEY}`
      }
    }
  );

  const users = await r.json();
  const user = users?.[0];

  if (!user || !user.password_hash) {
    return res.json({ status: "error", message: "Login fehlgeschlagen." });
  }

  const ok = await bcrypt.compare(password, user.password_hash);
  if (!ok) {
    return res.json({ status: "error", message: "Login fehlgeschlagen." });
  }

  await fetch(
    `${process.env.SUPABASE_URL}/rest/v1/users?id=eq.${user.id}`,
    {
      method: "PATCH",
      headers: {
        "Content-Type": "application/json",
        "apikey": process.env.SUPABASE_SERVICE_ROLE_KEY,
        "Authorization": `Bearer ${process.env.SUPABASE_SERVICE_ROLE_KEY}`
      },
      body: JSON.stringify({ last_login_at: new Date().toISOString() })
    }
  );

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
}