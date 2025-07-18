<?php
session_start();
require '../../includes/db.php';

if ($_SESSION['rol'] !== 'profesor') {
    header("Location: ../../dashboard.php");
    exit;
}

if (!isset($_GET['curso_id'])) {
    echo "Curso no especificado.";
    exit;
}

$curso_id = $_GET['curso_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];

    $stmt = $conn->prepare("INSERT INTO clases (curso_id, titulo, contenido) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $curso_id, $titulo, $contenido);
    $stmt->execute();

    header("Location: ver_clases.php?curso_id=" . $curso_id);
    exit;
}
?>

<div>
<h2>Agregar nueva clase</h2>

<form method="POST">
    <label>Título:</label><br>
    <input type="text" name="titulo" required><br><br>

    <label>Contenido:</label><br>
    <textarea name="contenido" rows="6" cols="50" required></textarea><br><br>

        <button type="submit">Guardar clase</button>
        <a href="../mis_cursos.php" class="btn-cancelar">Cancelar</a>
    
</form>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap');

* {
    font-family: 'Nunito', sans-serif;
    box-sizing: border-box;
}

div {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 40px 20px;
    min-height: 100vh;
    background: #f5f7fa;
}

h2 {
    margin-bottom: 30px;
    color: #333;
    text-align: center;
    width: 100%;
    max-width: 600px;
}

form {
    width: 100%;
    max-width: 600px;
    background: #fff;
    padding: 25px 30px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

label {
    font-weight: 600;
    display: block;
    margin-bottom: 6px;
    color: #444;
}

input[type="text"],
textarea {
    width: 100%;
    padding: 10px;
    font-size: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    resize: vertical;
    margin-bottom: 20px;
    font-family: inherit;
    color: #333;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus,
textarea:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 6px #a3c9f9;
}

.botones {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

button[type="submit"] {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 10px 22px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 700;
    font-size: 15px;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #217dbb;
}

.btn-cancelar {
    display: inline-block;
    background-color: #bbb;
    color: #333;
    text-decoration: none;
    padding: 10px 22px;
    border-radius: 5px;
    font-weight: 700;
    font-size: 15px;
    text-align: center;
    transition: background-color 0.3s ease;
}

.btn-cancelar:hover {
    background-color: #999;
}

</style>