<?php
session_start();
require_once __DIR__ . '/../config.php';
?>

<header>
    <div class="main-header">
        <div class="logo">
            <h2>KOLOG-7</h2>
        </div>
        <form class="search" method="GET" action="/buscar.php">
            <button type="submit">
                <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="search">
                    <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9"
                          stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </button>
            <input class="input" placeholder="Buscar..." type="text" name="q" />
            <button class="reset" type="reset">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </form>

        <div class="login">
            <?php if (!isset($_SESSION['usuario_id'])): ?>
                <a href="<?= BASE_URL ?>login.php" class="button-17">INICIAR SESIÓN</a>
            <?php else: ?>
                <div class="user-dropdown">
                    <button class="button-17"><?= htmlspecialchars($_SESSION['nombre']) ?></button>
                    <div class="dropdown-content">
                        <p>Hola, <?= $_SESSION['rol'] === 'profesor' ? 'profesor' : 'estudiante' ?> <?= htmlspecialchars($_SESSION['nombre']) ?>!</p>
                        <a href="<?= BASE_URL ?>usuario/configuracion.php">Configuración</a>
                        <?php if ($_SESSION['rol'] === 'profesor'): ?>
                            <a href="<?= BASE_URL ?>profesor/crear_curso.php">Crear curso</a>
                            <a href="<?= BASE_URL ?>profesor/mis_cursos.php">Ver mis cursos</a>
                        <?php endif; ?>
                        <a href="<?= BASE_URL ?>logout.php">Cerrar sesión</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <nav class="navbar">
    <ul>
        <li><a href="<?= BASE_URL ?>principal/index.php">Inicio</a></li>

        <?php if (isset($_SESSION['rol'])): ?>
            <?php if ($_SESSION['rol'] === 'profesor'): ?>
                <li><a href="<?= BASE_URL ?>profesor/mis_cursos.php">Mis cursos</a></li>
            <?php else: ?>
                <li><a href="<?= BASE_URL ?>estudiante/ver_cursos.php">Mis cursos</a></li>
                <li><a href="<?= BASE_URL ?>estudiante/cursos_disponibles.php">Cursos disponibles</a></li>
            <?php endif; ?>
        <?php endif; ?>

        <li><a href="<?= BASE_URL ?>principal/paginas/museo.php">Museo Virtual</a></li>
    </ul>
</nav>

</header>
