<?php
$host = "localhost";
$user = "root";
$pass = "2707";
$dbname = "area_estudio";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
