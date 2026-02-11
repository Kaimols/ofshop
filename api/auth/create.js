const bcrypt = require("bcryptjs");

module.exports = async function handler(req, res) {
  try {
    if (req.method !== "POST") {
      return res
        .status(405)
        .json({ status: "error", message: "Only POST allowed" });
    }

    const { username, password, cpassword, invite_token, reflink } = req.body || {};

    if (!username || !password || !cpassword) {
      return res.json({ status: "error", message: "Bitte alle Felder ausfüllen." });
    }

    if (password !== cpassword) {
      return res.json({ status: "error", message: "Passwörter stimmen nicht überein." });
    }

    if (!/^[a-zA-Z0-9_]{3,32}$/.test(username)) {
      return res.json({ status: "error", message: "Ungültiger Username." });
    }

    if (password.length < 8) {
      return res.json({ status: "error", message: "Passwort zu kurz (min. 8 Zeichen)." });
    }

    // ENV Checks (hilft beim Debuggen)
    if (!process.env.SUPABASE_URL || !process.env.SUPABASE_SERVICE_ROLE_KEY) {
      console.error("Missing env:", {
        SUPABASE_URL: !!process.env.SUPABASE_URL,
        SUPABASE_SERVICE_ROLE_KEY: !!process.env.SUPABASE_SERVICE_ROLE_KEY,
      });
      return res.status(500).json({ status: "error", message: "Serverkonfiguration fehlt." });
    }

    const password_hash = await bcrypt.hash(password, 12);

    const r = await fetch(`${process.env.SUPABASE_URL}/rest/v1/users`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        apikey: process.env.SUPABASE_SERVICE_ROLE_KEY,
        Authorization: `Bearer ${process.env.SUPABASE_SERVICE_ROLE_KEY}`,
        Prefer: "return=representation",
      },
      body: JSON.stringify({
        username,
        password_hash,
        invite_token: invite_token || null,
        reflink: reflink || null,
      }),
    });

    if (!r.ok) {
      const txt = await r.text();

      // Duplicate handling (PostgREST liefert oft Details)
      if (txt.toLowerCase().includes("duplicate") || txt.includes("23505")) {
        return res.json({ status: "error", message: "Username existiert bereits." });
      }

      console.error("Create failed:", r.status, txt);
      return res.status(500).json({ status: "error", message: "Serverfehler." });
    }

    return res.json({ status: "success", message: "Account erstellt." });
  } catch (err) {
    console.error("Unhandled error in /api/auth/create:", err);
    return res.status(500).json({ status: "error", message: "Serverfehler." });
  }
};