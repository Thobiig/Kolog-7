<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/styles/register_login.css">
</head>

<body>
    <!---  Inicio de la página -->
    <main>
        <div class="logo-container">
            <img src="assets\img\logo.png" alt="Logo Kolog-7" class="logo">
            <h3>KOLOG-7</h3>
        </div>

        <div class="base-container">

            <div class="form-container-login">
                    <h2>Iniciar sesión en Kolog-7</h2>

                <form class="login-form" action="login.php" method="POST">
                    <label for="email" class="sr-only">Correo electrónico</label>
                    <input type="email" name="email" placeholder="Correo" required>
                    <label for="contraseña" class="sr-only">Contrasñea</label>
                    <input type="password" name="contraseña" placeholder="****************" required>
                    <button type="submit">Iniciar sesión</button>
                    <p class="error escondido">Error al iniciar sesión</p>
                </form>
                
                <p>¿No tienes una cuenta? <a href="register.php">Regístrate</a></p>
            </div>
        </div>

    </main>
    <!---  Fin de la página -->
</body>

</html>

<?php
session_start();
require 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $contraseña = $_POST["contraseña"];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows == 1) {
        $usuario = $res->fetch_assoc();

        if (password_verify($contraseña, $usuario["contraseña"])) {
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["rol"] = $usuario["rol"];
            $_SESSION["nombre"] = $usuario["nombre"];

            header("Location: principal/index.php");
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
}
?>
