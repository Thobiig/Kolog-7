<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

echo "¡Hola, " . $_SESSION["nombre"] . "!<br>";
echo "Rol: " . $_SESSION["rol"] . "<br>";
echo "<a href='logout.php'>Cerrar sesión</a>";
?>

<?php
// después del saludo
if ($_SESSION['rol'] === 'profesor') {
    echo "<a href='profesor/crear_curso.php'>Crear curso</a><br>";
} elseif ($_SESSION['rol'] === 'estudiante') {
    echo "<a href='estudiante/ver_cursos.php'>Ver cursos e inscribirse</a><br>
    <a href='estudiante/ver_todos_los_cursos.php'>Ver cursos disponibles</a>";
}
?>

<?php if ($_SESSION['rol'] === 'profesor'): ?>
    <a href="profesor/clases/agregar_clase.php">Agregar clase</a><br>
<?php endif; ?>
