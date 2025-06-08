<?php
session_start();
require '../includes/db.php';

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

<h2>Mis cursos</h2>

<?php while ($curso = $result->fetch_assoc()): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <h3><?= $curso['nombre'] ?></h3>
        <p><?= $curso['descripcion'] ?></p>
        <a href='cursos/ver_clases.php?curso_id=<?= $curso['id'] ?>'>Ver clases</a>
    </div>
<?php endwhile; ?>
