import { pool } from '../db.js'; // Asegúrate de que db.js exporte correctamente `pool`

// 1) Obtener todas las preguntas junto con sus respuestas
export const obtenerPreguntas = async (req, res) => {
  try {
    // Hacemos un LEFT JOIN para traer preguntas y sus respuestas en un solo query
    const [rows] = await pool.query(`
      SELECT
        p.id AS preguntaId,
        p.pregunta,
        p.nivel,
        r.id       AS respuestaId,
        r.texto,
        r.es_correcta
      FROM preguntas p
      LEFT JOIN respuestas r ON r.id_pregunta = p.id
      ORDER BY p.id ASC, r.id ASC
    `);

    // Agrupamos manualmente cada pregunta con su arreglo de respuestas
    const agrupado = {};
    for (const fila of rows) {
      const pid = fila.preguntaId;
      if (!agrupado[pid]) {
        agrupado[pid] = {
          id: pid,
          pregunta: fila.pregunta,
          nivel: fila.nivel,
          respuestas: []
        };
      }
      if (fila.respuestaId) {
        agrupado[pid].respuestas.push({
          id: fila.respuestaId,
          texto: fila.texto,
          es_correcta: fila.es_correcta === 1 // convertir a booleano
        });
      }
    }

    // Convertimos a arreglo para devolverlo como JSON
    const resultado = Object.values(agrupado);
    return res.json(resultado);
  } catch (err) {
    console.error(err);
    return res.status(500).json({ error: 'Error al obtener preguntas' });
  }
};

// 2) Crear pregunta (solo profesores, protegido desde las rutas con middleware)
export const crearPregunta = async (req, res) => {
  try {
    const { pregunta, nivel, respuestas } = req.body;

    // Insertar en tabla preguntas
    const [result] = await pool.query(
      'INSERT INTO preguntas (pregunta, nivel) VALUES (?, ?)',
      [pregunta, nivel]
    );
    const preguntaId = result.insertId;

    // Insertar cada respuesta asociada
    for (const r of respuestas) {
      await pool.query(
        'INSERT INTO respuestas (id_pregunta, texto, es_correcta) VALUES (?, ?, ?)',
        [preguntaId, r.texto, r.es_correcta ? 1 : 0]
      );
    }

    return res.status(201).json({ message: 'Pregunta creada exitosamente' });
  } catch (err) {
    console.error(err);
    return res.status(500).json({ error: 'Error al crear la pregunta' });
  }
};
