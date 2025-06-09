<?php
session_start();
require '../includes/db.php';
require_once __DIR__ . '/../config.php';

if ($_SESSION['rol'] !== 'estudiante') {
    header("Location: ../dashboard.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$mensaje = "";

// Si el estudiante envió el formulario para inscribirse
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscribirse'])) {
    $curso_id = intval($_POST['curso_id']);

    // Verificar si ya está inscrito
    $check = $conn->prepare("SELECT * FROM inscripciones WHERE usuario_id = ? AND curso_id = ?");
    $check->bind_param("ii", $usuario_id, $curso_id);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows === 0) {
        // Inscribir al estudiante
        $insert = $conn->prepare("INSERT INTO inscripciones (usuario_id, curso_id) VALUES (?, ?)");
        $insert->bind_param("ii", $usuario_id, $curso_id);
        if ($insert->execute()) {
            $mensaje = "✅ Te has inscrito correctamente.";
        } else {
            $mensaje = "❌ Error al inscribirte. Intenta nuevamente.";
        }
    } else {
        $mensaje = "⚠️ Ya estás inscrito en este curso.";
    }
}

// Consultar cursos en los que NO está inscrito
$query = $conn->prepare("
    SELECT c.id, c.nombre, c.descripcion 
    FROM cursos c 
    WHERE c.id NOT IN (
        SELECT curso_id FROM inscripciones WHERE usuario_id = ?
    )
");
$query->bind_param("i", $usuario_id);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cursos disponibles</title>
</head>
<body>

    <h2>Cursos disponibles</h2>

    <?php if (!empty($mensaje)): ?>
        <div style="padding:10px; background:#e0ffe0; border:1px solid green; margin-bottom:20px;">
            <?= $mensaje ?>
        </div>
    <?php endif; ?>

    <?php while ($curso = $result->fetch_assoc()): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
            <h3><?= htmlspecialchars($curso['nombre']) ?></h3>
            <p><?= htmlspecialchars($curso['descripcion']) ?></p>
            <form method="POST">
                <input type="hidden" name="curso_id" value="<?= $curso['id'] ?>">
                <button type="submit" name="inscribirse">Inscribirme</button>
            </form>
        </div>
    <?php endwhile; ?>

    <a href="<?= BASE_URL ?>principal/index.php">
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

        div {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        h3 {
            margin-top: 0;
            color: #007BFF;
        }

        p {
            color: #555;
        }

        form {
            margin-top: 10px;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        a button {
            display: block;
            margin: 30px auto 0;
        }

        div[style*="background:#e0ffe0"] {
            background-color: #e0ffe0 !important;
            border: 1px solid green !important;
            color: #2e7d32;
            font-weight: bold;
            border-radius: 5px;
        }
    </style>
</body>
</html>
