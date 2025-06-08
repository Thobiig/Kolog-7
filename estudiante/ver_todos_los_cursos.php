<?php
session_start();
require '../includes/db.php';

if ($_SESSION['rol'] !== 'estudiante') {
    header("Location: ../dashboard.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Cursos en los que NO está inscrito
$query = $conn->prepare("
    SELECT c.id, c.nombre, c.descripcion 
    FROM cursos c 
    WHERE c.id NOT IN (
        SELECT curso_id FROM inscripciones WHERE usuario_id = ?
    )
");
$query->bind_param("i", $usuario_id);
$query->execute();
$result = $query->get_result();
?>

<h2>Cursos disponibles</h2>

<?php while ($curso = $result->fetch_assoc()): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <h3><?= $curso['nombre'] ?></h3>
        <p><?= $curso['descripcion'] ?></p>
        <form method="POST" action="inscribirse.php">
            <input type="hidden" name="curso_id" value="<?= $curso['id'] ?>">
            <button type="submit">Inscribirme</button>
        </form>
    </div>
<?php endwhile; ?>
