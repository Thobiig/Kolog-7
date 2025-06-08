<?php
session_start();
require '../includes/db.php';

if ($_SESSION['rol'] !== 'profesor') {
    header("Location: ../dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $profesor_id = $_SESSION['usuario_id'];

    $sql = "INSERT INTO cursos (nombre, descripcion, profesor_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $descripcion, $profesor_id);
    
    if ($stmt->execute()) {
        echo "Curso creado exitosamente.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre del curso" required>
    <textarea name="descripcion" placeholder="Descripción"></textarea>
    <button type="submit">Crear curso</button>
</form>
