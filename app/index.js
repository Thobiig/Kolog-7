import express from 'express';

//fix para __dirname   
import path from 'path';
import { fileURLToPath } from 'url';
const __dirname = path.dirname(fileURLToPath(import.meta.url));
import {methods as authentication} from './pages/authentication.controller.js';

//Server
const app = express();
app.set("port", 4000);
app.listen(app.get("port"));
console.log("Servidor corriendo en el puerto", app.get("port"));

//Configuracion
app.use(express.static(__dirname + "/public"));


//Rutas
app.get("/", (req, res) => res.sendFile(__dirname + "/pages/login.html"));
app.get("/register", (req, res) => res.sendFile(__dirname + "/pages/register.html"));
app.get("/home", (req, res) => res.sendFile(__dirname + "/pages/home.html"));
app.post("/api/register", authentication.register);
app.post("/api/login", authentication.login);