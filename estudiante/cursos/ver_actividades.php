<?php
session_start();
require '../../includes/db.php';

if ($_SESSION['rol'] !== 'estudiante') {
    header("Location: ../../dashboard.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$curso_id = $_GET['curso_id'] ?? null;

// Validar inscripción
$check = $conn->prepare("SELECT * FROM inscripciones WHERE usuario_id = ? AND curso_id = ?");
$check->bind_param("ii", $usuario_id, $curso_id);
$check->execute();
if ($check->get_result()->num_rows == 0) {
    echo "No estás inscrito en este curso.";
    exit;
}

// Obtener actividades
$stmt = $conn->prepare("SELECT id, titulo, descripcion, fecha_entrega FROM actividades WHERE curso_id = ?");
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$actividades = $stmt->get_result();
?>

<h2>Actividades del curso</h2>

<?php while ($actividad = $actividades->fetch_assoc()): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <strong><?= $actividad['titulo'] ?></strong><br>
        <small>Entrega hasta: <?= $actividad['fecha_entrega'] ?></small>
        <p><?= nl2br($actividad['descripcion']) ?></p>
        <form method="POST" action="enviar_actividad.php">
            <input type="hidden" name="actividad_id" value="<?= $actividad['id'] ?>">
            <textarea name="respuesta" placeholder="Tu respuesta..." required rows="4" cols="50"></textarea><br><br>
            <button type="submit">Enviar respuesta</button>
        </form>
    </div>
<?php endwhile; ?>
