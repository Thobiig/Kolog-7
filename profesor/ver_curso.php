<?php
session_start();
require '../includes/db.php';

if ($_SESSION['rol'] !== 'profesor') {
    header("Location: ../dashboard.php");
    exit;
}

if (!isset($_GET['curso_id'])) {
    echo "Curso no especificado.";
    exit;
}

$curso_id = intval($_GET['curso_id']);

// Obtener información del curso
$curso_stmt = $conn->prepare("SELECT nombre FROM cursos WHERE id = ?");
$curso_stmt->bind_param("i", $curso_id);
$curso_stmt->execute();
$curso_result = $curso_stmt->get_result();

if ($curso_result->num_rows === 0) {
    echo "Curso no encontrado.";
    exit;
}

$curso = $curso_result->fetch_assoc();
$nombre_curso = $curso['nombre'];

// Obtener clases del curso
$clases_stmt = $conn->prepare("SELECT * FROM clases WHERE curso_id = ?");
$clases_stmt->bind_param("i", $curso_id);
$clases_stmt->execute();
$clases_result = $clases_stmt->get_result();
?>

<h2>Clases del curso: <?= htmlspecialchars($nombre_curso) ?></h2>
<a href="dashboard.php">← Volver a mis cursos</a><br><br>

<a href="clases/agregar_clase.php?curso_id=<?= $curso_id ?>">➕ Agregar nueva clase</a><br><br>

<a href="ver_participantes.php?curso_id=<?= $curso_id ?>">👥 Ver participantes</a><br>
<a href="examenes/ver_examenes.php?curso_id=<?= $curso_id ?>">📝 Ver exámenes</a><br>
<a href="ver_notas.php?curso_id=<?= $curso_id ?>">📊 Ver calificaciones</a><br><br>

<?php if ($clases_result->num_rows > 0): ?>
    <?php while ($clase = $clases_result->fetch_assoc()): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
            <h3><?= htmlspecialchars($clase['titulo']) ?></h3>
            <p><?= nl2br(htmlspecialchars($clase['contenido'])) ?></p>
            <a href="clases/editar_clase.php?id=<?= $clase['id'] ?>&curso_id=<?= $curso_id ?>">✏️ Editar</a> |
            <a href="clases/eliminar_clase.php?id=<?= $clase['id'] ?>&curso_id=<?= $curso_id ?>" onclick="return confirm('¿Eliminar esta clase?')">🗑️ Eliminar</a>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No hay clases agregadas aún.</p>
<?php endif; ?>
