<?php
session_start();
require '../../includes/db.php';

if ($_SESSION['rol'] !== 'estudiante') {
    header("Location: ../../dashboard.php");
    exit;
}

$curso_id = $_GET['curso_id'] ?? null;
$usuario_id = $_SESSION['usuario_id'];

// Validar inscripción del estudiante
$check = $conn->prepare("SELECT * FROM inscripciones WHERE usuario_id = ? AND curso_id = ?");
$check->bind_param("ii", $usuario_id, $curso_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows == 0) {
    echo "No estás inscrito en este curso.";
    exit;
}

// Obtener clases
$stmt = $conn->prepare("SELECT titulo, contenido, fecha_publicacion FROM clases WHERE curso_id = ? ORDER BY fecha_publicacion DESC");
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$clases = $stmt->get_result();
?>

<h2>Clases del curso</h2>
<?php while ($clase = $clases->fetch_assoc()): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <strong><?= $clase['titulo'] ?></strong><br>
        <small>Publicado el <?= $clase['fecha_publicacion'] ?></small><br>
        <p><?= nl2br($clase['contenido']) ?></p>
    </div>
<?php endwhile; ?>
