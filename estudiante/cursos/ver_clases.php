<?php
session_start();
require '../../includes/db.php';

if ($_SESSION['rol'] !== 'estudiante') {
    header("Location: ../../dashboard.php");
    exit;
}

if (!isset($_GET['curso_id'])) {
    echo "Curso no especificado.";
    exit;
}

$curso_id = intval($_GET['curso_id']);

// Obtener información del curso
$cursoQuery = $conn->prepare("SELECT nombre FROM cursos WHERE id = ?");
$cursoQuery->bind_param("i", $curso_id);
$cursoQuery->execute();
$cursoResult = $cursoQuery->get_result();
$curso = $cursoResult->fetch_assoc();

// Obtener clases del curso
$clasesQuery = $conn->prepare("SELECT * FROM clases WHERE curso_id = ?");
$clasesQuery->bind_param("i", $curso_id);
$clasesQuery->execute();
$clasesResult = $clasesQuery->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Clases del curso <?= htmlspecialchars($curso['nombre']) ?></title>
</head>
<body>

    <h2>Clases del curso: <?= htmlspecialchars($curso['nombre']) ?></h2>

    <?php if ($clasesResult->num_rows > 0): ?>
        <ul>
            <?php while ($clase = $clasesResult->fetch_assoc()): ?>
                <li>
                    <strong><?= htmlspecialchars($clase['titulo']) ?></strong><br>
                    <?= nl2br(htmlspecialchars($clase['contenido'])) ?>
                </li>
                <hr>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No hay clases aún en este curso.</p>
    <?php endif; ?>

    <a href="../../estudiante/ver_cursos.php">
            <button type="">Regresar</button>
    </a>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        button {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #5a6268;
        }

        button[onclick] {
            display: block;
            margin: 0 auto 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        li strong {
            color: #007BFF;
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
        }

        hr {
            border: none;
            border-top: 1px solid #eee;
            margin: 15px 0;
        }

        p {
            text-align: center;
            color: #666;
        }

        a button {
            background-color: #007BFF;
            margin: 30px auto 0;
            display: block;
        }

        a button:hover {
            background-color: #0056b3;
        }
    </style>

</body>
</html>
