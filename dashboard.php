<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Administración - Sinaptium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="../estilos_bo/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="icon" href="../logo/cerebro.svg" type="image/x-icon">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <div class="text-center mb-4">
                    <img src="../logo/logo.svg" alt="Logo" class="img-fluid" style="max-width: 120px;">
                    <h5 class="mt-2">Panel de Administración</h5>
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-users"></i>
                            <span>Usuarios</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-user-tag"></i>
                            <span>Roles</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-key"></i>
                            <span>Permisos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog"></i>
                            <span>Configuración</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">
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
                    <h4>Dashboard de Administración</h4>
                    <div>
                        <span class="me-3">Hola, <?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
                        <img src="https://ui-avatars.com/api/?name=Admin&background=3b82f6&color=fff" class="rounded-circle" width="40" alt="Avatar">
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="card stats-card">
                            <i class="fas fa-users"></i>
                            <h2>142</h2>
                            <p>Usuarios Totales</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stats-card">
                            <i class="fas fa-user-tag"></i>
                            <h2>6</h2>
                            <p>Roles</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stats-card">
                            <i class="fas fa-key"></i>
                            <h2>18</h2>
                            <p>Permisos</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stats-card">
                            <i class="fas fa-clock"></i>
                            <h2>3</h2>
                            <p>Usuarios Nuevos (7d)</p>
                        </div>
                    </div>
                </div>

                <!-- Users Table -->
                <?php include_once './usuarios/usuarios.php';?>

                <!-- Roles and Permissions -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Roles del Sistema</span>
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i> Nuevo Rol
                                </button>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Administrador
                                        <span class="badge bg-primary rounded-pill">5 usuarios</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Editor
                                        <span class="badge bg-info rounded-pill">8 usuarios</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Instructor
                                        <span class="badge bg-warning rounded-pill">12 usuarios</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Estudiante
                                        <span class="badge bg-success rounded-pill">117 usuarios</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Permisos</span>
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i> Nuevo Permiso
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-secondary p-2">lectura</span>
                                    <span class="badge bg-secondary p-2">escritura</span>
                                    <span class="badge bg-secondary p-2">eliminación</span>
                                    <span class="badge bg-secondary p-2">administración</span>
                                    <span class="badge bg-secondary p-2">crear_usuarios</span>
                                    <span class="badge bg-secondary p-2">editar_usuarios</span>
                                    <span class="badge bg-secondary p-2">eliminar_usuarios</span>
                                    <span class="badge bg-secondary p-2">ver_reportes</span>
                                </div>
                            </div>
                        </div>
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