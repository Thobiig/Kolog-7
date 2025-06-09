<?php
session_start();
require '../includes/db.php';

if ($_SESSION['rol'] !== 'profesor') {
    header('Location: ../dashboard.php');
    exit;
}

$profesor_id = $_SESSION['usuario_id'];

// Obtener exámenes del profesor
$examenes = $conn->query("SELECT e.id, e.titulo, c.nombre AS curso
                          FROM examenes e
                          JOIN cursos c ON e.curso_id = c.id
                          WHERE c.profesor_id = $profesor_id");
?>

<h2>Notas de exámenes</h2>

<?php while ($examen = $examenes->fetch_assoc()): ?>
    <h3><?= htmlspecialchars($examen['titulo']) ?> (<?= htmlspecialchars($examen['curso']) ?>)</h3>

    <?php
    $stmt = $conn->prepare("SELECT u.nombre, r.nota
                            FROM respuestas_examen r
                            JOIN usuarios u ON r.usuario_id = u.id
                            WHERE r.examen_id = ?");
    $stmt->bind_param("i", $examen['id']);
    $stmt->execute();
    $resultados = $stmt->get_result();
    ?>

    <?php if ($resultados->num_rows > 0): ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Estudiante</th>
                <th>Nota</th>
            </tr>
            <?php while ($fila = $resultados->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($fila['nombre']) ?></td>
                    <td><?= $fila['nota'] ?>/100</td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No hay respuestas registradas para este examen.</p>
    <?php endif; ?>

<?php endwhile; ?>

<br><a href="index.php">← Volver al panel</a>
