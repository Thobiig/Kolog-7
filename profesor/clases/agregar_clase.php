<?php
session_start();
require '../../includes/db.php';

if ($_SESSION['rol'] !== 'profesor') {
    header("Location: ../../dashboard.php");
    exit;
}

// Obtener los cursos del profesor
$profesor_id = $_SESSION['usuario_id'];
$cursos = $conn->query("SELECT id, nombre FROM cursos WHERE profesor_id = $profesor_id");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $curso_id = $_POST['curso_id'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];

    $stmt = $conn->prepare("INSERT INTO clases (curso_id, titulo, contenido) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $curso_id, $titulo, $contenido);
    
    if ($stmt->execute()) {
        echo "Clase agregada correctamente.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<h2>Agregar clase</h2>
<form method="POST">
    <label>Curso:</label>
    <select name="curso_id" required>
        <?php while ($curso = $cursos->fetch_assoc()): ?>
            <option value="<?= $curso['id'] ?>"><?= $curso['nombre'] ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <input type="text" name="titulo" placeholder="Título de la clase" required><br><br>
    <textarea name="contenido" placeholder="Contenido..." rows="6" cols="50" required></textarea><br><br>
    <button type="submit">Crear clase</button>
</form>
