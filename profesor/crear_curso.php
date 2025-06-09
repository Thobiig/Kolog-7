<?php
session_start();
require '../includes/db.php';

if ($_SESSION['rol'] !== 'profesor') {
    header("Location: ../dashboard.php");
    exit;
}

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $profesor_id = $_SESSION['usuario_id'];

    $sql = "INSERT INTO cursos (nombre, descripcion, profesor_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $descripcion, $profesor_id);
    
    if ($stmt->execute()) {
        $mensaje = "✅ Curso creado exitosamente.";
    } else {
        $mensaje = "❌ Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Crear Curso</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap');

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
            box-sizing: border-box;
        }

        main {
            background-color: #fff;
            max-width: 600px;
            width: 100%;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            box-sizing: border-box;
        }

        h2 {
            margin-top: 0;
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 25px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        textarea {
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            font-family: 'Nunito', sans-serif;
            resize: vertical;
        }

        .boton-azul {
            background-color: #3498db;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 10px;
            transition: background-color 0.3s ease;
        }

        .boton-azul:hover {
            background-color: #217dbb;
        }

        .boton-gris {
            background-color: #bdc3c7;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
        }

        .boton-gris:hover {
            background-color: #95a5a6;
        }

        .mensaje {
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
            color: #27ae60;
        }

        .error {
            color: #e74c3c;
        }
    </style>
</head>
<body>

<main>
    <h2>Crear un curso nuevo</h2>

    <?php if (!empty($mensaje)): ?>
        <div class="mensaje <?= strpos($mensaje, 'Error') !== false ? 'error' : '' ?>">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre del curso" required>
        <textarea name="descripcion" placeholder="Descripción" rows="4"></textarea>
        <button type="submit" class="boton-azul">Crear curso</button>
    </form>

    <a href="../principal/index.php" class="boton-gris">Cancelar</a>
</main>

</body>
</html>
