<?php
session_start();
require '../includes/db.php';
require_once __DIR__ . '/../config.php';

if ($_SESSION['rol'] !== 'estudiante') {
    header("Location: ../dashboard.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$query = $conn->prepare("SELECT cursos.id, cursos.nombre, cursos.descripcion 
                         FROM cursos 
                         INNER JOIN inscripciones ON cursos.id = inscripciones.curso_id 
                         WHERE inscripciones.usuario_id = ?");
$query->bind_param("i", $usuario_id);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mis cursos</title>
</head>
<body>

<h2>Mis cursos</h2>

<?php while ($curso = $result->fetch_assoc()): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <h3><?= htmlspecialchars($curso['nombre']) ?></h3>
        <p><?= htmlspecialchars($curso['descripcion']) ?></p>

        <a href="<?= BASE_URL ?>estudiante/cursos/ver_clases.php?curso_id=<?= $curso['id'] ?>">📚 Ver clases</a> |
        <a href="<?= BASE_URL ?>estudiante/examenes/index.php?curso_id=<?= $curso['id'] ?>">📝 Ver exámenes</a> |
        <a href="<?= BASE_URL ?>estudiante/notas.php?curso_id=<?= $curso['id'] ?>">📊 Ver notas</a>
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

        a {
            text-decoration: none;
            color: #007BFF;
            margin-right: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        a button {
            display: block;
            margin: 0 auto;
        }
    </style>
</body>
</html>
