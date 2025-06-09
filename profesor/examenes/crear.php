<?php
session_start();
require '../../includes/db.php';

if ($_SESSION['rol'] !== 'profesor') {
    header('Location: ../../dashboard.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener cursos del profesor
$stmt = $conn->prepare("SELECT id, nombre FROM cursos WHERE profesor_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$cursos = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $curso_id = $_POST['curso_id'];

    $insert = $conn->prepare("INSERT INTO examenes (curso_id, titulo) VALUES (?, ?)");
    $insert->bind_param("is", $curso_id, $titulo);
    $insert->execute();

    $nuevo_examen_id = $insert->insert_id;
    header("Location: agregar_preguntas.php?examen_id=$nuevo_examen_id");
    exit;
}
?>

<h2>Crear nuevo examen</h2>

<form method="POST">
    <label>Título del examen:</label><br>
    <input type="text" name="titulo" required><br><br>

    <label>Curso:</label><br>
    <select name="curso_id" required>
        <?php while ($curso = $cursos->fetch_assoc()): ?>
            <option value="<?= $curso['id'] ?>"><?= $curso['nombre'] ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <button type="submit">Crear examen</button>
    <a href="../mis_cursos.php"><button type="button">Cancelar</button></a>
</form>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Crear nuevo examen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        form {
            background-color: #fff;
            max-width: 500px;
            margin: 0 auto;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            margin-top: 20px;
            padding: 10px 18px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 14px;
        }

        button:hover {
            background-color: #0056b3;
        }

        a button {
            background-color: #6c757d;
            margin-left: 10px;
        }

        a button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
