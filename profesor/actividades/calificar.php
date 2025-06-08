<?php
session_start();
require '../../includes/db.php';

if ($_SESSION['rol'] !== 'profesor') {
    header("Location: ../../dashboard.php");
    exit;
}

$entrega_id = $_POST['entrega_id'];
$nota = $_POST['nota'];

$stmt = $conn->prepare("UPDATE entregas SET nota = ? WHERE id = ?");
$stmt->bind_param("di", $nota, $entrega_id);

if ($stmt->execute()) {
    echo "Nota guardada.";
} else {
    echo "Error al calificar.";
}
?>
