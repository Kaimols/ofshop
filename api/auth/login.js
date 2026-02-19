const bcrypt = require("bcryptjs");
const jwt = require("jsonwebtoken");

module.exports = async function handler(req, res) {
  if (req.method !== "POST") {
    return res.status(405).json({ status: "error", message: "Only POST allowed" });
  }

  const { username, password } = req.body || {};
  if (!username || !password) {
    return res.json({ status: "error", message: "Bitte alle Felder ausfüllen." });
  }

  if (!process.env.SUPABASE_URL || !process.env.SUPABASE_SERVICE_ROLE_KEY || !process.env.JWT_SECRET) {
    console.error("Missing env");
    return res.status(500).json({ status: "error", message: "Server-Konfiguration fehlt (ENV)." });
  }

  const url =
    `${process.env.SUPABASE_URL}/rest/v1/users` +
    `?select=id,username,password_hash` +
    `&username=eq.${encodeURIComponent(username)}`;

  const r = await fetch(url, {
    headers: {
      apikey: process.env.SUPABASE_SERVICE_ROLE_KEY,
      Authorization: `Bearer ${process.env.SUPABASE_SERVICE_ROLE_KEY}`,
      Accept: "application/json",
    },
  });

  if (!r.ok) {
    const txt = await r.text();
    console.error("Supabase fetch failed:", r.status, txt);
    return res.status(500).json({ status: "error", message: "Serverfehler (DB Query)." });
  }

  const users = await r.json();
  const user = users?.[0];

  if (!user || !user.password_hash) {
    return res.json({ status: "error", message: "Login fehlgeschlagen." });
  }

  const ok = await bcrypt.compare(password, user.password_hash);
  if (!ok) {
    return res.json({ status: "error", message: "Login fehlgeschlagen." });
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
console.log("LOGIN_SUCCESS", user.id);
  return res.json({ status: "success", message: "Login erfolgreich." });
};