import jwt from "jsonwebtoken";

export default function handler(req, res) {
  try {
    const cookie = req.headers.cookie || "";
    const match = cookie.match(/(?:^|;\s*)session=([^;]+)/);
    if (!match) return res.status(401).json({ auth: false });

    jwt.verify(match[1], process.env.JWT_SECRET);
    return res.json({ auth: true });
  } catch (e) {
    return res.status(401).json({ auth: false });
  }
}