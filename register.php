<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Kolog-7</title>
    <link rel="stylesheet" href="assets/styles/register_login.css">
</head>

<body>
    <main>
        <div class="base-container">
            <div class="form-container">
                <h2>Crea tu cuenta en Kolog-7</h2>

                <form class="register-form" id="register-form" action="register.php" method="POST">
                    <label for="nombre" class="sr-only">Nombre</label>
                    <input type="text" name="nombre" placeholder="Nombre" required>

                    <label for="email" class="sr-only">Correo electrónico</label>
                    <input type="email" name="email" placeholder="Correo" required>

                    <label for="password" class="sr-only">Contraseña</label>
                    <input type="password" name="contraseña" placeholder="Contraseña" required>

                    <label for="confirm-password" class="sr-only">Confirmar contraseña</label>
                    <input type="password" name="confirmar_contraseña" placeholder="Confirmar contraseña" required>

                    <div class="nacimiento-container">
                        <h4 class="texto">Fecha de nacimiento</h4>
                        <div class="select-group">
                          <div class="select-wrapper">
                                <select name="dia" required>
                                <option value="" disabled selected>Día</option>
                                <script>
                                  for (let i = 1; i <= 31; i++) {
                                      document.write(`<option value="${i < 10 ? '0' + i : i}">${i}</option>`);
                                  }
                                </script>
                                </select>
                            </div>
                        
                        
                            <div class="select-wrapper">             
                            <select name="mes" required>
                                <option value="" disabled selected>Mes</option>
                                <option value="01">Enero</option>
                                <option value="02">Febrero</option>
                                <option value="03">Marzo</option>
                                <option value="04">Abril</option>
                                <option value="05">Mayo</option>
                                <option value="06">Junio</option>
                                <option value="07">Julio</option>
                                <option value="08">Agosto</option>
                                <option value="09">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                            </div>    
                                
                            <div class="select-wrapper">
                            <select name="anio" required>
                                <option value="" disabled selected>Año</option>
                                <script>
                                    const currentYear = new Date().getFullYear()-9;
                                    for (let i = 0; i < 100; i++) {
                                        const year = currentYear - i;
                                        document.write(`<option value="${year}">${year}</option>`);
                                    }
                                </script>
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="rol">
                      <h4>Seleccione su rol</h4>
                      <div class="select-wrapper" class="rol">
                        <select name="rol" required>
                            <option value="estudiante">Estudiante</option>
                            <option value="profesor">Profesor</option>
                        </select>
                      </div>             
                    </div>

                    

                    <button type="submit">Registrarse</button>
                </form>
                <p>¿Ya estás registrado? <a href="login.php">Inicia sesión</a></p>
            </div>
        </div>

        <div class="logo-container">
            <img src="assets\img\logo.png" alt="Logo Kolog-7" class="logo">
            <h3>KOLOG-7</h3>
        </div>
    </main>
</body>

</html>



<?php
require 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $password = $_POST["contraseña"];
    $confirmar = $_POST["confirmar_contraseña"];
    $rol = $_POST["rol"];

    $dia = $_POST["dia"];
    $mes = $_POST["mes"];
    $anio = $_POST["anio"];
    $fechaNacimiento = "$anio-$mes-$dia";

    // Verificar que las contraseñas coincidan
    if ($password !== $confirmar) {
        die("Las contraseñas no coinciden.");
    }

    // Hashear la contraseña
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, email, contraseña, fecha_nacimiento, rol) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $email, $hash, $fechaNacimiento, $rol);

    if ($stmt->execute()) {
        echo "Usuario registrado correctamente. <a href='login.php'>Iniciar sesión</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>