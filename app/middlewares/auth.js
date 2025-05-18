// app/middlewares/auth.js
import jwt from 'jsonwebtoken';

export function verificarToken(req, res, next) {
  const authHeader = req.headers.authorization;

  if (!authHeader) return res.status(401).json({ error: 'Token no proporcionado' });

  const token = authHeader.split(' ')[1];

  try {
    const decoded = jwt.verify(token, 'secreto'); // usa la misma clave secreta
    req.user = decoded; // agrega los datos del usuario a la request
    next();
  } catch (err) {
    return res.status(403).json({ error: 'Token inválido' });
  }
}

export function soloProfesores(req, res, next) {
  if (req.user.rol !== 'profesor') {
    return res.status(403).json({ error: 'Acceso denegado: solo profesores' });
  }
  next();
}
