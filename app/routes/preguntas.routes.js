// app/routes/preguntas.routes.js
import { Router } from 'express';
import { crearPregunta, obtenerPreguntas } from '../controllers/preguntas.controller.js';
import { verificarToken, soloProfesores } from '../middlewares/auth.js';

const router = Router();

// Todas pueden ver preguntas
router.get("/", obtenerPreguntas);

// Solo profesores pueden crear preguntas
router.post("/", verificarToken, soloProfesores, crearPregunta);

export default router;
