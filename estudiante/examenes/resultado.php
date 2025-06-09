<?php
session_start();
require '../../includes/db.php';

if ($_SESSION['rol'] !== 'estudiante') {
    header('Location: ../../dashboard.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$examen_id = $_GET['examen_id'] ?? null;

// Verificar que el estudiante haya respondido ese examen
$stmt = $conn->prepare("SELECT nota FROM respuestas_examen WHERE usuario_id = ? AND examen_id = ?");
$stmt->bind_param("ii", $usuario_id, $examen_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo "<p>No has resuelto este examen.</p>";
    echo "<a href='index.php'>Volver</a>";
    exit;
}

$datos = $res->fetch_assoc();
$nota = $datos['nota'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado del Examen</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            box-sizing: border-box;
        }
        main {
            background-color: #fff;
            max-width: 500px;
            width: 100%;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 25px;
        }
        p {
            font-size: 20px;
            margin-bottom: 30px;
        }
        strong {
            color: #2980b9;
        }
        .boton-gris {
            background-color: #bdc3c7;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .boton-gris:hover {
            background-color: #95a5a6;
        }
    </style>
</head>
<body>
    <main>
        <h2>Resultado del examen</h2>
        <p>Tu calificación fue: <strong><?= htmlspecialchars($nota) ?> / 100</strong></p>
        <a href="index.php" class="boton-gris">Regresar al inicio</a>
    </main>
</body>
</html>
