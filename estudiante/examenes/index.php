<?php
session_start();
require '../../includes/db.php';

if ($_SESSION['rol'] !== 'estudiante') {
    header('Location: ../../dashboard.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Buscar cursos inscritos
$cursos = $conn->prepare("SELECT curso_id FROM inscripciones WHERE usuario_id = ?");
$cursos->bind_param("i", $usuario_id);
$cursos->execute();
$resultado = $cursos->get_result();

$curso_ids = [];
while ($fila = $resultado->fetch_assoc()) {
    $curso_ids[] = $fila['curso_id'];
}

$examenes = [];
if (count($curso_ids) > 0) {
    $ids_str = implode(',', $curso_ids);
    $sql = "SELECT e.id, e.titulo, c.nombre AS curso 
            FROM examenes e 
            JOIN cursos c ON e.curso_id = c.id 
            WHERE e.curso_id IN ($ids_str)";
    $examenes = $conn->query($sql);
}
?>

<h2>Exámenes disponibles</h2>

<?php if ($examenes && $examenes->num_rows > 0): ?>
    <ul>
    <?php while ($examen = $examenes->fetch_assoc()): ?>
        <li>
            <strong><?= htmlspecialchars($examen['titulo']) ?></strong> (Curso: <?= htmlspecialchars($examen['curso']) ?>)
            - <a href="resolver.php?examen_id=<?= $examen['id'] ?>">Resolver</a>
        </li>
    <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>No hay exámenes disponibles.</p>
<?php endif; ?>

 <a href="../../estudiante/ver_cursos.php">
            <button type="">Regresar</button>
</a>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exámenes disponibles</title>
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

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            font-size: 16px;
        }

        li strong {
            color: #007BFF;
            display: block;
            margin-bottom: 8px;
        }

        a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            text-align: center;
            color: #666;
        }

        a button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            display: block;
            margin: 30px auto 0;
            transition: background-color 0.3s ease;
        }

        a button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

