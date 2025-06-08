<?php
session_start();
require '../../includes/db.php';

if ($_SESSION['rol'] !== 'profesor') {
    header("Location: ../../dashboard.php");
    exit;
}

$actividad_id = $_GET['actividad_id'] ?? null;

$query = $conn->prepare("
    SELECT entregas.id, usuarios.nombre, entregas.respuesta, entregas.nota
    FROM entregas
    JOIN usuarios ON usuarios.id = entregas.estudiante_id
    WHERE entregas.actividad_id = ?");
$query->bind_param("i", $actividad_id);
$query->execute();
$entregas = $query->get_result();
?>

<h2>Entregas de Actividad</h2>

<?php while ($e = $entregas->fetch_assoc()): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <strong><?= $e['nombre'] ?></strong><br>
        <p><?= nl2br($e['respuesta']) ?></p>
        <form method="POST" action="calificar.php">
            <input type="hidden" name="entrega_id" value="<?= $e['id'] ?>">
            <input type="number" step="0.1" name="nota" placeholder="Nota" value="<?= $e['nota'] ?>"><br>
            <button type="submit">Guardar nota</button>
        </form>
    </div>
<?php endwhile; ?>
