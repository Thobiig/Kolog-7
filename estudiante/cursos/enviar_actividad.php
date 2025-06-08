<?php
session_start();
require '../../includes/db.php';

if ($_SESSION['rol'] !== 'estudiante') {
    header("Location: ../../dashboard.php");
    exit;
}

$actividad_id = $_POST['actividad_id'];
$respuesta = $_POST['respuesta'];
$usuario_id = $_SESSION['usuario_id'];

// Validar si ya entregó
$check = $conn->prepare("SELECT * FROM entregas WHERE actividad_id = ? AND estudiante_id = ?");
$check->bind_param("ii", $actividad_id, $usuario_id);
$check->execute();
if ($check->get_result()->num_rows > 0) {
    echo "Ya has enviado esta actividad.";
    exit;
}

// Insertar entrega
$stmt = $conn->prepare("INSERT INTO entregas (actividad_id, estudiante_id, respuesta) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $actividad_id, $usuario_id, $respuesta);

if ($stmt->execute()) {
    echo "Actividad enviada con éxito.";
} else {
    echo "Error al enviar: " . $stmt->error;
}
?>
