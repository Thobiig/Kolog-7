// app/index.js
import express from 'express';
import path from 'path';
import { fileURLToPath } from 'url';

import preguntasRoutes from './routes/preguntas.routes.js';
import * as auth from './controllers/authentication.controller.js'; // ✅ Mover arriba

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const app = express();

app.set("port", 4000);

// Middleware para leer JSON
app.use(express.json());

// Servir archivos estáticos desde la carpeta public
app.use(express.static(path.join(__dirname, 'public')));

// Rutas de páginas
app.get("/", (req, res) => res.sendFile(path.join(__dirname, "pages", "home.html")));
app.get("/register", (req, res) => res.sendFile(path.join(__dirname, "pages", "register.html")));
app.get("/login", (req, res) => res.sendFile(path.join(__dirname, "pages", "login.html")));
app.get("/museo", (req, res) => res.sendFile(path.join(__dirname, "pages", "museo.html")));
app.get("/preguntas", (req, res) => res.sendFile(path.join(__dirname, "pages", "preguntas.html")));

// Rutas API
app.post("/api/register", auth.register); // ✅ usar `auth`
app.post("/api/login", auth.login);
app.use("/api/preguntas", preguntasRoutes);

// 404 para rutas no encontradas
app.use((req, res) => res.status(404).sendFile(path.join(__dirname, "pages", "error.html")));

// Iniciar servidor
app.listen(app.get("port"), () => {
    console.log("Servidor corriendo en http://localhost:" + app.get("port"));
});
