<?php
session_start();
require '../../includes/db.php';

if ($_SESSION['rol'] !== 'estudiante') {
    header('Location: ../../dashboard.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$examen_id = $_GET['examen_id'] ?? null;

// Verificar si ya respondió
$verificar = $conn->prepare("SELECT id FROM respuestas_examen WHERE usuario_id = ? AND examen_id = ?");
$verificar->bind_param("ii", $usuario_id, $examen_id);
$verificar->execute();
$res = $verificar->get_result();

if ($res->num_rows > 0) {
    // Mostrar mensaje presentable en HTML
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8" />
        <title>Examen ya realizado</title>
        <style>
            body {
                font-family: 'Segoe UI', sans-serif;
                background-color: #f0f2f5;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .mensaje-contenedor {
                background: #fff;
                padding: 30px 40px;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.15);
                max-width: 400px;
                text-align: center;
            }
            h2 {
                color: #e74c3c;
                margin-bottom: 20px;
            }
            p {
                font-size: 18px;
                margin-bottom: 30px;
                color: #333;
            }
            a.boton-gris {
                background-color: #bdc3c7;
                color: white;
                padding: 12px 25px;
                border-radius: 6px;
                font-weight: bold;
                text-decoration: none;
                display: inline-block;
                transition: background-color 0.3s;
            }
            a.boton-gris:hover {
                background-color: #95a5a6;
            }
        </style>
    </head>
    <body>
        <div class="mensaje-contenedor">
            <h2>¡Atención!</h2>
            <p>Ya respondiste este examen.</p>
            <a href="index.php" class="boton-gris">Volver al inicio</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Obtener preguntas
$stmt = $conn->prepare("SELECT * FROM preguntas WHERE examen_id = ?");
$stmt->bind_param("i", $examen_id);
$stmt->execute();
$preguntas = $stmt->get_result();

// Guardar respuestas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nota = 0;
    $total = 0;

    foreach ($preguntas as $pregunta) {
        $preg_id = $pregunta['id'];
        $respuesta = $_POST["respuesta_$preg_id"] ?? null;

        if ($respuesta && intval($respuesta) === intval($pregunta['correcta'])) {
            $nota++;
        }

        $total++;
    }

    $puntaje = round(($nota / $total) * 100, 2);

    $guardar = $conn->prepare("INSERT INTO respuestas_examen (usuario_id, examen_id, nota) VALUES (?, ?, ?)");
    $guardar->bind_param("iid", $usuario_id, $examen_id, $puntaje);
    $guardar->execute();

    header("Location: resultado.php?examen_id=$examen_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Resolver Examen</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            box-sizing: border-box;
            margin: 0;
        }

        main {
            background-color: #fff;
            width: 100%;
            max-width: 700px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }

        .pregunta {
            margin-bottom: 25px;
        }

        .pregunta strong {
            display: block;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin: 5px 0;
            cursor: pointer;
        }

        input[type="radio"] {
            margin-right: 10px;
            cursor: pointer;
        }

        .boton-azul {
            background-color: #3498db;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            margin-top: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .boton-azul:hover {
            background-color: #2c80b4;
        }

        .boton-gris {
            background-color: #bdc3c7;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            width: 96.5%;
            margin-top: 10px;
            text-align: center;
            display: block;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .boton-gris:hover {
            background-color: #95a5a6;
        }

        .boton-cancelar-contenedor {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<main>
    <h2>Resolver examen</h2>

    <form method="POST">
        <?php foreach ($preguntas as $pregunta): ?>
            <div class="pregunta">
                <strong><?= htmlspecialchars($pregunta['enunciado']) ?></strong>
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <?php if (!empty($pregunta["opcion$i"])): ?>
                        <label>
                            <input type="radio" name="respuesta_<?= $pregunta['id'] ?>" value="<?= $i ?>" required>
                            <?= htmlspecialchars($pregunta["opcion$i"]) ?>
                        </label>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="boton-azul">Enviar examen</button>
    </form>

    <div class="boton-cancelar-contenedor">
        <a href="index.php" class="boton-gris">Cancelar</a>
    </div>
</main>

</body>
</html>
