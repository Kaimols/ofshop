// api/auth/me.js
import jwt from "jsonwebtoken";

export default async function handler(req, res) {
  try {
    const cookie = req.headers.cookie || "";
    const m = cookie.match(/(?:^|;\s*)session=([^;]+)/);
    if (!m) return res.status(401).json({ ok: false });

    const token = decodeURIComponent(m[1]);
    const payload = jwt.verify(token, process.env.JWT_SECRET);

    return res.json({
      ok: true,
      user: { id: payload.uid, username: payload.username }
    });
  } catch (e) {
    return res.status(401).json({ ok: false });
  }
}