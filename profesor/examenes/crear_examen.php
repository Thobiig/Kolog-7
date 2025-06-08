<?php
session_start();
require '../../includes/db.php';

if ($_SESSION['rol'] !== 'profesor') {
    header('Location: ../../dashboard.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener cursos del profesor
$stmt = $conn->prepare("SELECT id, nombre FROM cursos WHERE profesor_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$cursos = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $curso_id = $_POST['curso_id'];

    $insert = $conn->prepare("INSERT INTO examenes (curso_id, titulo) VALUES (?, ?)");
    $insert->bind_param("is", $curso_id, $titulo);
    $insert->execute();

    $nuevo_examen_id = $insert->insert_id;
    header("Location: agregar_preguntas.php?examen_id=$nuevo_examen_id");
    exit;
}
?>

<h2>Crear nuevo examen</h2>

<form method="POST">
    <label>Título del examen:</label><br>
    <input type="text" name="titulo" required><br><br>

    <label>Curso:</label><br>
    <select name="curso_id" required>
        <?php while ($curso = $cursos->fetch_assoc()): ?>
            <option value="<?= $curso['id'] ?>"><?= $curso['nombre'] ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <button type="submit">Crear examen</button>
</form>
