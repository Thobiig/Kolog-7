// app/controllers/authentication.controller.js
import bcrypt from 'bcrypt';
import jwt from 'jsonwebtoken';
import { pool } from '../db.js'; // asegúrate de tener esto configurado

// Registrar usuario
export async function register(req, res) {
  const { nombre, correo, contraseña, rol } = req.body;

  try {
    // Verificar si el usuario ya existe
    const [existing] = await pool.query('SELECT * FROM usuarios WHERE correo = ?', [correo]);
    if (existing.length > 0) {
      return res.status(400).json({ error: 'El usuario ya existe' });
    }

    const saltRounds = 10;
    const hashedPassword = await bcrypt.hash(contraseña, saltRounds);

    await pool.query(
      'INSERT INTO usuarios (nombre, correo, contraseña, rol) VALUES (?, ?, ?, ?)',
      [nombre, correo, hashedPassword, rol]
    );

    res.json({ message: "Usuario registrado correctamente" });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "Error al registrar usuario" });
  }
}

// Iniciar sesión
export async function login(req, res) {
  const { correo, contraseña } = req.body;

  try {
    const [rows] = await pool.query('SELECT * FROM usuarios WHERE correo = ?', [correo]);

    if (rows.length === 0) return res.status(404).json({ error: 'Usuario no encontrado' });

    const usuario = rows[0];
    const match = await bcrypt.compare(contraseña, usuario.contraseña);
    if (!match) return res.status(401).json({ error: 'Contraseña incorrecta' });

    const token = jwt.sign({ id: usuario.id, rol: usuario.rol }, 'secreto', { expiresIn: '1h' });

    res.json({ message: 'Login exitoso', token, rol: usuario.rol });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: 'Error al iniciar sesión' });
  }
}
