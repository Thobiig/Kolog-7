<?php
session_start();
require '../includes/db.php';

if ($_SESSION['rol'] !== 'estudiante') {
    header('Location: ../dashboard.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$stmt = $conn->prepare("SELECT r.nota, e.titulo, c.nombre AS curso
                        FROM respuestas_examen r
                        JOIN examenes e ON r.examen_id = e.id
                        JOIN cursos c ON e.curso_id = c.id
                        WHERE r.usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<h2>Mis notas</h2>

<?php if ($resultado->num_rows > 0): ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Curso</th>
            <th>Examen</th>
            <th>Nota</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($fila['curso']) ?></td>
                <td><?= htmlspecialchars($fila['titulo']) ?></td>
                <td><?= $fila['nota'] ?> / 100.00</td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>Aún no has presentado ningún examen.</p>
<?php endif; ?>

 <a href="../estudiante/ver_cursos.php">
            <button type="">Regresar</button>
</a>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mis notas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        table {
            margin: 0 auto 30px;
            border-collapse: collapse;
            width: 90%;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        p {
            text-align: center;
            color: #666;
        }

        a button {
            display: block;
            margin: 0 auto;
            padding: 10px 20px;
            font-size: 14px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        a button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
