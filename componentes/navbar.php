<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';

$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand logo" href="dashboard.php">
            <img src="<?php echo BASE_URL; ?>logo/logo.svg" alt="Sinaptium Logo" class="navbar-logo" width="200" height="50">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == '/' || $current_page == '') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>">
                        Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'nosotros.php') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>nosotros.php">
                        Nosotros
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'funcionamiento.php') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>funcionamiento.php">
                        ¿Cómo funciona?
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'biblioteca.php') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>biblioteca/biblioteca.php">
                        Biblioteca
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'areas.php') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>areas.php">
                        Áreas Académicas
                    </a>
                </li>
                
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <!-- Mostrar cuando el usuario está logueado -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo htmlspecialchars($_SESSION['usuario']); ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- Mostrar cuando no hay sesión activa -->
                    <li class="nav-item">
                        <a class="btn btn-glow btn-lg me-3" href="<?php echo BASE_URL; ?>login">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>