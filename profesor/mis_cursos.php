<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== 'profesor') {
    header("Location: ../login.php");
    exit;
}

$profesor_id = $_SESSION["usuario_id"];

$stmt = $conn->prepare("SELECT id, nombre, descripcion FROM cursos WHERE profesor_id = ?");
$stmt->bind_param("i", $profesor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis cursos</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap');

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f3f5f7;
            padding: 30px;
            color: #333;
            display: flex;
            justify-content: center; /* centra todo horizontalmente */
            box-sizing: border-box;
            margin: 0;
            min-height: 100vh;
        }

        main {
            width: 100%;
            max-width: 700px; /* ancho máximo para que no sea muy ancho */
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 700px;
            margin: 0 auto 20px auto;
            padding: 0 10px;
        }

        .top h2 {
            color: #333;
            font-weight: 700;
            font-size: 24px;
            margin: 0;
        }

        .top a button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .top a button:hover {
            background-color: #217dbb;
        }

        .curso {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            padding: 20px 25px;
            margin: 15px auto;
            max-width: 100%;
            box-sizing: border-box;
            transition: transform 0.2s;
            width: auto; /* ancho automático según contenido */
        }

        .curso:hover {
            transform: scale(1.02);
        }

        h3 {
            margin-top: 0;
            color: #007BFF;
        }

        p {
            margin-bottom: 15px;
        }

        ul.acciones-curso {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding-left: 0;
            list-style: none;
            margin-top: 10px;
        }

        ul.acciones-curso li {
            margin: 0;
        }

        ul.acciones-curso a {
            display: inline-block;
            padding: 8px 12px;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.2s;
            font-size: 14px;
        }

        ul.acciones-curso a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="contendor">


<div class="top">
    <h2>Mis cursos</h2>
    <a href="../principal/index.php"><button type="button">Regresar al inicio</button></a>
</div>

<div class="buttom">
    <?php while ($curso = $result->fetch_assoc()): ?>
        <div class="curso">
            <h3><?= htmlspecialchars($curso['nombre']) ?></h3>
            <p><?= htmlspecialchars($curso['descripcion']) ?></p>
            <ul class="acciones-curso">
                <li><a href="ver_integrantes.php?curso_id=<?= $curso['id'] ?>">👥 Ver integrantes</a></li>
                <li><a href="clases/ver_clases.php?curso_id=<?= $curso['id'] ?>">📝 Ver clases</a></li>
                <li><a href="clases/agregar_clase.php?curso_id=<?= $curso['id'] ?>">➕ Agregar clase</a></li>
                <li><a href="examenes/crear.php?curso_id=<?= $curso['id'] ?>">❓ Crear examen</a></li>
                <li><a href="ver_notas.php?curso_id=<?= $curso['id'] ?>">📊 Ver notas</a></li>
            </ul>
        </div>
    <?php endwhile; ?>
</div>
</div>

</body>
</html>
