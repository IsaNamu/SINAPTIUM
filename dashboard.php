<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';

// Includes (para el servidor)
include_once HOME_PATH . 'verificar_sesion.php';
if (!isset($_SESSION['permisos']) || 
    !in_array('dashboard:Lee', $_SESSION['permisos']) || 
    strtolower($_SESSION['rol_nombre']) !== 'administrador') {
    
    $_SESSION['mensaje'] = [
        'tipo' => 'danger',
        'texto' => 'ACCESO DENEGADO: NO TIENES PERMISOS DE ADMINISTRADOR'
    ];
    header("Location: " . BASE_URL);
    exit;
}

include_once HOME_PATH . 'cx/peticiones.php';
include_once HOME_PATH . 'componentes/head_component.php';
$permisos = (isset($_SESSION['permisos']) && in_array('permiso:Lee', $_SESSION['permisos'])) 
    ? listarRegistros('permisos') 
    : [];
$usuarios = (isset($_SESSION['permisos']) && in_array('usuario:Lee', $_SESSION['permisos'])) 
    ? listarRegistros('usuario') 
    : [];
    
$roles = (isset($_SESSION['permisos']) && in_array('rol:Lee', $_SESSION['permisos'])) 
    ? listarRegistros('roles') 
    : [];

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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php renderHead('Dashboard de Administración - Sinaptium'); ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/dashboard.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <div class="text-center mb-4">
                    <img src="<?php echo BASE_URL; ?>logo/logo.svg" alt="Logo" class="img-fluid" style="max-width: 120px;">
                    <h5 class="mt-2">Panel de Administración</h5>  
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $seccion == 'dashboard' ? 'active' : ''; ?>" href="?seccion=dashboard">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <?php if (isset($_SESSION['permisos']) && in_array('biblioteca:Lee', $_SESSION['permisos'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $seccion == 'biblioteca' ? 'active' : ''; ?>" href="?seccion=biblioteca">
                                <i class="fas fa-book"></i>
                                <span>Biblioteca</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['permisos']) && in_array('aprendizaje:Lee', $_SESSION['permisos'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $seccion == 'aprendizajes' ? 'active' : ''; ?>" href="?seccion=aprendizajes">
                                <i class="fas fa-graduation-cap"></i> <!-- Icono sugerido para aprendizaje -->
                                <span>Aprendizaje</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['permisos']) && in_array('usuario:Lee', $_SESSION['permisos'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $seccion == 'usuarios' ? 'active' : ''; ?>" href="?seccion=usuarios">
                                <i class="fas fa-users"></i>
                                <span>Usuarios</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['permisos']) && in_array('rol:Lee', $_SESSION['permisos'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $seccion == 'roles' ? 'active' : ''; ?>" href="?seccion=roles">
                                <i class="fas fa-user-tag"></i>
                                <span>Roles</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['permisos']) && in_array('permiso:Lee', $_SESSION['permisos'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $seccion == 'permisos' ? 'active' : ''; ?>" href="?seccion=permisos">
                                <i class="fas fa-key"></i>
                                <span>Permisos</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/Sinaptium">
                            <i class="fas fa-home"></i>
                            <span>Inicio</span>
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a class="nav-link" href="./logout.php">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Salir</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <div class="header">
                    <h4>
                        <?php 
                        switch($seccion) {
                            case 'dashboard': echo 'Dashboard de Administración'; break;
                            case 'biblioteca': echo 'Gestionar biblioteca'; break;
                            case 'usuarios': echo 'Gestión de Usuarios'; break;
                            case 'roles': echo 'Gestión de Roles'; break;
                            case 'permisos': echo 'Gestión de Permisos'; break;
                            case 'aprendizajes': echo 'Contenido aprendizaje'; break;
                            default: echo 'Dashboard de Administración';
                        }
                        ?>
                    </h4>
                    <div>
                        <span class="me-3">Hola, <?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
                        <img src="https://ui-avatars.com/api/?name=Admin&background=3b82f6&color=fff" class="rounded-circle" width="40" alt="Avatar">
                    </div>
                </div>

                <?php
                // Renderizar la sección correspondiente
                switch($seccion) {
                    case 'dashboard':
                        include './data_dashboard.php';
                        break;
                    case 'usuarios':
                        include './usuarios/usuarios.php';
                        break;
                    case 'roles':
                        include './roles/roles.php';
                        break;
                    case 'permisos':
                        include './permisos/permisos.php';
                        break;
                    case 'biblioteca':
                        include './biblioteca/dashboard.php';
                        break;
                    case 'aprendizajes':
                        include './aprendizaje/dashboard.php';
                        break;
                    default:
                        include './biblioteca/dashboard.php';
                }
                ?>
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