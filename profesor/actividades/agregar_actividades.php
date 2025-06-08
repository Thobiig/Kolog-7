<?php
session_start();
require '../../includes/db.php';

if ($_SESSION['rol'] !== 'profesor') {
    header("Location: ../../dashboard.php");
    exit;
}

$profesor_id = $_SESSION['usuario_id'];
$cursos = $conn->query("SELECT id, nombre FROM cursos WHERE profesor_id = $profesor_id");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $curso_id = $_POST['curso_id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_entrega = $_POST['fecha_entrega'];

    $stmt = $conn->prepare("INSERT INTO actividades (curso_id, titulo, descripcion, fecha_entrega) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $curso_id, $titulo, $descripcion, $fecha_entrega);

    if ($stmt->execute()) {
        echo "Actividad creada correctamente.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<h2>Crear Actividad</h2>
<form method="POST">
    <label>Curso:</label>
    <select name="curso_id" required>
        <?php while ($curso = $cursos->fetch_assoc()): ?>
            <option value="<?= $curso['id'] ?>"><?= $curso['nombre'] ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <input type="text" name="titulo" placeholder="Título" required><br><br>
    <textarea name="descripcion" placeholder="Descripción..." rows="6" cols="50" required></textarea><br><br>
    <label>Fecha de entrega:</label>
    <input type="date" name="fecha_entrega" required><br><br>

    <button type="submit">Crear actividad</button>
</form>
