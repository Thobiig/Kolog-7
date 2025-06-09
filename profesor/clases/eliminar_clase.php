<?php
session_start();
require '../../includes/db.php';

if ($_SESSION['rol'] !== 'profesor') {
    header("Location: ../../dashboard.php");
    exit;
}

if (!isset($_GET['id']) || !isset($_GET['curso_id'])) {
    echo "Clase o curso no especificado.";
    exit;
}

$clase_id = $_GET['id'];
$curso_id = $_GET['curso_id'];

$stmt = $conn->prepare("DELETE FROM clases WHERE id = ?");
$stmt->bind_param("i", $clase_id);
$stmt->execute();

header("Location: ver_clases.php?curso_id=" . $curso_id);
exit;
