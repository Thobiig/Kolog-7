<?php
session_start();
require_once '../includes/db.php';  // Ajusta la ruta según tu estructura

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$mensaje = '';

// Obtener datos actuales del usuario
$stmt = $conn->prepare("SELECT nombre, email FROM usuarios WHERE id = ?");
$stmt->bind_param('i', $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Usuario no encontrado.");
}
$usuario = $result->fetch_assoc();

// Procesar formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];  // Nuevo password, puede estar vacío

    // Validaciones básicas
    if (empty($nombre) || empty($email)) {
        $mensaje = "❌ Nombre y correo no pueden estar vacíos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "❌ Correo electrónico inválido.";
    } else {
        if (!empty($password)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $update_stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, contraseña = ? WHERE id = ?");
            $update_stmt->bind_param('sssi', $nombre, $email, $password_hash, $usuario_id);
        } else {
            $update_stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?");
            $update_stmt->bind_param('ssi', $nombre, $email, $usuario_id);
        }

        if ($update_stmt->execute()) {
            $mensaje = "✅ Datos actualizados correctamente.";
            $usuario['nombre'] = $nombre;
            $usuario['email'] = $email;
        } else {
            $mensaje = "❌ Error al actualizar datos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Configuración de usuario</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap');

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f9fafb;
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
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 15px;
            font-weight: 600;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            font-family: 'Nunito', sans-serif;
            box-sizing: border-box;
        }

        .boton-azul {
            background-color: #3498db;
            color: white;
            padding: 12px;
            margin-top: 20px;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .boton-azul:hover {
            background-color: #217dbb;
        }

        .boton-gris {
            background-color: #bdc3c7;
            color: white;
            padding: 12px;
            margin-top: 10px;
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
            margin-top: 20px;
            color: #27ae60;
        }

        .error {
            text-align: center;
            font-size: 16px;
            margin-top: 20px;
            color: #e74c3c;
        }
    </style>
</head>
<body>

<main>
    <h1>Configuración de usuario</h1>

    <?php if ($mensaje): ?>
        <p class="<?= strpos($mensaje, '❌') === 0 ? 'error' : 'mensaje' ?>"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required />

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required />

        <label for="password">Nueva contraseña (dejar vacío para no cambiar):</label>
        <input type="password" id="password" name="password" />

        <button type="submit" class="boton-azul">Guardar cambios</button>
    </form>

    <a href="../principal/index.php" class="boton-gris">Cancelar</a>
</main>

</body>
</html>
