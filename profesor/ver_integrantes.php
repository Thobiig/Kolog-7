<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== 'profesor') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['curso_id'])) {
    echo "Curso no especificado.";
    exit;
}

$curso_id = intval($_GET['curso_id']);

$stmt = $conn->prepare("
    SELECT u.id, u.nombre, u.email
    FROM inscripciones i
    INNER JOIN usuarios u ON i.usuario_id = u.id
    WHERE i.curso_id = ?
");
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Integrantes del curso</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap');

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 30px 20px;
            color: #2c3e50;
            display: flex;
            justify-content: center;
            box-sizing: border-box;
            min-height: 100vh;
        }

        main {
            max-width: 700px;
            width: 100%;
            background: #fff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            box-sizing: border-box;
        }

        h2 {
            margin-top: 0;
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 20px;
            color: #34495e;
            text-align: center;
        }

        p {
            font-size: 16px;
            text-align: center;
            color: #555;
            margin-bottom: 20px;
        }

        ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 25px;
        }

        li {
            background-color: #f3f5f7;
            margin-bottom: 10px;
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 16px;
            color: #2c3e50;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        a > button {
            display: block;
            margin: 0 auto;
            background-color: #3498db;
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 700;
            font-size: 16px;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        a > button:hover {
            background-color: #217dbb;
        }
    </style>
</head>
<body>

<main>
    <h2>Integrantes del curso</h2>

    <?php if ($result->num_rows === 0): ?>
        <p>No hay estudiantes inscritos en este curso.</p>
    <?php else: ?>
        <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li><?= htmlspecialchars($row['nombre']) ?> (<?= htmlspecialchars($row['email']) ?>)</li>
        <?php endwhile; ?>
        </ul>
    <?php endif; ?>

    <a href="mis_cursos.php"><button type="button">Regresar</button></a>
</main>

</body>
</html>
