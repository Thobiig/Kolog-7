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

// Obtener clases del curso
$stmt = $conn->prepare("SELECT * FROM clases WHERE curso_id = ?");
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Clases del curso</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap');

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
        }

        .clase {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .clase h2 {
            margin: 0;
            font-weight: 700;
            font-size: 24px;
        }

        .clase a button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
            font-size: 15px;
        }

        .clase a button:hover {
            background-color: #217dbb;
        }

        .clase-item {
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
            box-sizing: border-box;
            width: auto;
        }

        .clase-item h3 {
            margin-top: 0;
            margin-bottom: 8px;
            color: #34495e;
        }

        .clase-item p {
            white-space: pre-wrap;
            line-height: 1.5;
            color: #555;
            margin-bottom: 15px;
        }

        .clase-item a {
            margin-right: 10px;
            text-decoration: none;
        }

        .clase-item a button {
            background-color: #3498db;
            border: none;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
            font-size: 14px;
        }

        .clase-item a button:hover {
            background-color: #217dbb;
        }

        .regresar a > button {
            background-color: #6c757d;
            padding: 8px 16px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
            font-size: 15px;
        }

        .regresar a > button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<main>
    <div class="clase">
        <h2>Clases del curso</h2>
        <a href="agregar_clase.php?curso_id=<?= $curso_id ?>"><button type="button">➕ Agregar nueva clase</button></a>
    </div>

    <?php while ($clase = $resultado->fetch_assoc()): ?>
        <div class="clase-item">
            <h3><?= htmlspecialchars($clase['titulo']) ?></h3>
            <p><?= nl2br(htmlspecialchars($clase['contenido'])) ?></p>
            <a href="editar_clase.php?id=<?= $clase['id'] ?>&curso_id=<?= $curso_id ?>"><button type="button">✏️ Editar</button></a>
            <a href="eliminar_clase.php?id=<?= $clase['id'] ?>&curso_id=<?= $curso_id ?>" onclick="return confirm('¿Estás seguro de eliminar esta clase?')">
                <button type="button">🗑️ Eliminar</button>
            </a>
        </div>
    <?php endwhile; ?>

    <div class="regresar">
        <a href="../mis_cursos.php"><button type="button">Regresar</button></a>
    </div>
</main>

</body>
</html>
