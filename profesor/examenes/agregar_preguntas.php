<?php
session_start();
require '../../includes/db.php';

if ($_SESSION['rol'] !== 'profesor') {
    header('Location: ../../dashboard.php');
    exit;
}

$examen_id = $_GET['examen_id'] ?? null;

if (!$examen_id) {
    echo "Examen no especificado.";
    exit;
}

// Obtener datos del examen
$stmt = $conn->prepare("SELECT e.titulo, c.nombre AS curso FROM examenes e 
    JOIN cursos c ON e.curso_id = c.id 
    WHERE e.id = ?");
$stmt->bind_param("i", $examen_id);
$stmt->execute();
$result = $stmt->get_result();
$examen = $result->fetch_assoc();

if (!$examen) {
    echo "Examen no encontrado.";
    exit;
}

// Guardar nueva pregunta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enunciado = $_POST['enunciado'];
    $op1 = $_POST['opcion1'];
    $op2 = $_POST['opcion2'];
    $op3 = $_POST['opcion3'];
    $op4 = $_POST['opcion4'];
    $correcta = $_POST['correcta'];

    $insert = $conn->prepare("INSERT INTO preguntas (examen_id, enunciado, opcion1, opcion2, opcion3, opcion4, correcta) 
                              VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insert->bind_param("isssssi", $examen_id, $enunciado, $op1, $op2, $op3, $op4, $correcta);
    $insert->execute();
}
?>

<h2>Examen: <?= htmlspecialchars($examen['titulo']) ?> (Curso: <?= htmlspecialchars($examen['curso']) ?>)</h2>

<form method="POST">
    <label>Enunciado de la pregunta:</label><br>
    <textarea name="enunciado" required></textarea><br><br>

    <label>Opción 1:</label><br>
    <input type="text" name="opcion1" required><br>

    <label>Opción 2:</label><br>
    <input type="text" name="opcion2" required><br>

    <label>Opción 3:</label><br>
    <input type="text" name="opcion3"><br>

    <label>Opción 4:</label><br>
    <input type="text" name="opcion4"><br><br>

    <label>Opción correcta:</label><br>
    <select name="correcta" required>
        <option value="1">Opción 1</option>
        <option value="2">Opción 2</option>
        <option value="3">Opción 3</option>
        <option value="4">Opción 4</option>
    </select><br><br>

    <button type="submit">Agregar pregunta</button>
    <a href="crear.php"><button type="button">Finalizar y volver</button></a>

<a href="crear.php"><button type="button">Cancelar</button></a>
</form>

<div class="botones">
    
</div>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar pregunta - <?= htmlspecialchars($examen['titulo']) ?></title>
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
            max-width: 600px;
            margin: 0 auto;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        button {
            margin-top: 20px;
            padding: 10px 18px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        a button {
            background-color: #6c757d;
            margin: 0 10px;
        }

        a button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
