<?php
session_start();
require '../includes/db.php';

if ($_SESSION['rol'] !== 'estudiante') {
    header("Location: ../dashboard.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$curso_id = $_POST['curso_id'];

// Prevenir inscripción duplicada
$check = $conn->prepare("SELECT * FROM inscripciones WHERE usuario_id = ? AND curso_id = ?");
$check->bind_param("ii", $usuario_id, $curso_id);
$check->execute();
if ($check->get_result()->num_rows === 0) {
    $stmt = $conn->prepare("INSERT INTO inscripciones (usuario_id, curso_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $usuario_id, $curso_id);
    $stmt->execute();
    echo "Inscripción exitosa.";
} else {
    echo "Ya estás inscrito en este curso.";
}
?>
