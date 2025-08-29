<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
}

if (!defined('HOME_PATH')) {
    define('HOME_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');
}

// Includes (para el servidor)
include_once HOME_PATH . 'cx/peticiones.php';
include_once HOME_PATH . 'componentes/head_component.php';
$permisos = listarRegistros('permisos');
$usuarios = listarRegistros('usuario');
$roles = listarRegistros('roles');

// Determinar la sección activa
$seccion = isset($_GET['seccion']) ? $_GET['seccion'] : 'dashboard';

// Contar usuarios por rol - FORMA CORRECTA
$conteoPorRol = [];
foreach ($roles as $rol) {
    $conteoPorRol[$rol['id']] = 0; // Usamos el ID real del rol como clave
}

foreach ($usuarios as $usuario) {
    if (isset($usuario['rol_id']) && isset($conteoPorRol[$usuario['rol_id']])) {
        $conteoPorRol[$usuario['rol_id']]++;
    }
}

function obtenerColorRol($nombreRol) {
    switch (strtolower($nombreRol)) {
        case 'administrador':
            return 'primary';
        case 'editor':
            return 'info';
        case 'instructor':
            return 'warning';
        default:
            return 'secondary';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php renderHead('Dashboard de Administración - Sinaptium'); ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/dashboard.css">
</head>
<body>
    <div class="row">
        <?php if (isset($_SESSION['permisos']) && in_array('usuario:Lee', $_SESSION['permisos'])): ?>
            <div class="col-md-3">
                <div class="card stats-card">
                    <i class="fas fa-users"></i>
                    <h2><?php echo count($usuarios); ?></h2>
                    <p>Usuarios Totales</p>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-md-3">
            <div class="card stats-card">
                <i class="fas fa-user-tag"></i>
                <h2><?php echo count($roles); ?></h2>
                <p>Roles</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <i class="fas fa-key"></i>
                <h2><?php echo count($permisos); ?></h2>
                <p>Permisos</p>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <?php if (isset($_SESSION['permisos']) && in_array('usuario:Lee', $_SESSION['permisos'])): ?>
        <?php include_once './usuarios/usuarios.php';?>
    <?php endif; ?>
    
    <!-- Roles and Permissions -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Roles del Sistema</span>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php foreach ($roles as $rol): ?>
                            <?php if (isset($conteoPorRol[$rol['id']]) && $conteoPorRol[$rol['id']] > 0): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo htmlspecialchars($rol['nombre']); ?>
                                    <span class="badge bg-<?php echo obtenerColorRol($rol['nombre']); ?> rounded-pill">
                                        <?php echo $conteoPorRol[$rol['id']]; ?> usuarios
                                    </span>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Permisos</span>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($permisos as $permiso): ?>
                            <span class="badge bg-secondary"><?php echo htmlspecialchars($permiso['nombre']); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ejemplo: Alternar sidebar en dispositivos móviles
            const sidebarToggler = document.createElement('button');
            sidebarToggler.className = 'btn btn-primary d-md-none position-fixed';
            sidebarToggler.style.bottom = '20px';
            sidebarToggler.style.right = '20px';
            sidebarToggler.style.zIndex = '1000';
            sidebarToggler.innerHTML = '<i class="fas fa-bars"></i>';
            
            document.body.appendChild(sidebarToggler);
            
            sidebarToggler.addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('show');
            });
        });
    </script>
</body>
</html>