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
include_once HOME_PATH . 'verificar_sesion.php';
include_once HOME_PATH . 'cx/peticiones.php';

// Mostrar mensajes si existen
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    echo "<div class='alert alert-{$mensaje['tipo']} alert-dismissible fade show' role='alert'>
            {$mensaje['texto']}
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
    unset($_SESSION['mensaje']);
}

// Obtener todos los permisos
$permisos = listarRegistros('permisos');

// Si hay error, mostrarlo
if (isset($permisos['error'])) {
    echo '<div class="alert alert-danger">Error: ' . $permisos['error'] . '</div>';
    $permisos = [];
}

// Determinar si estamos en modo edición
$modoEdicion = false;
$permisoEditar = null;
if (isset($_GET['editar'])) {
    $modoEdicion = true;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permisos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="<?php echo BASE_URL; ?>estilos_bo/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/dashboard.css">
    <link rel="icon" href="<?php echo BASE_URL; ?>logo/cerebro.svg" type="image/x-icon">
</head>
<body>
<!-- Permisos Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Lista de Permisos</span>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalPermiso" data-mode="create">
            <i class="fas fa-plus me-1"></i> Nuevo Permiso
        </button>
    </div>
    <div class="card-body">
        <?php if (empty($permisos)): ?>
            <div class="alert alert-info">
                No hay permisos registrados en el sistema.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($permisos as $permiso): ?>
                            <tr>
                                <td><?php echo $permiso['id']; ?></td>
                                <td><?php echo htmlspecialchars($permiso['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($permiso['descripcion'] ?? 'Sin descripción'); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary action-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalPermiso"
                                            data-mode="edit"
                                            data-id="<?php echo $permiso['id']; ?>"
                                            data-nombre="<?php echo htmlspecialchars($permiso['nombre']); ?>"
                                            data-descripcion="<?php echo htmlspecialchars($permiso['descripcion'] ?? ''); ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger action-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEliminarPermiso"
                                            data-id="<?php echo $permiso['id']; ?>"
                                            data-nombre="<?php echo htmlspecialchars($permiso['nombre']); ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal único para Crear/Editar Permiso -->
<div class="modal fade" id="modalPermiso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPermisoTitle">Crear Nuevo Permiso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo BASE_URL; ?>permisos/guardar_permiso.php" method="POST" id="formPermiso">
                <input type="hidden" id="permisoId" name="id">
                <input type="hidden" id="formMode" name="mode" value="create">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputNombre" class="form-label">Nombre del Permiso</label>
                        <input type="text" class="form-control" id="inputNombre" name="nombre" required>
                        <div class="form-text">El nombre debe ser único (ej: crear_usuarios, editar_permisos)</div>
                    </div>
                    <div class="mb-3">
                        <label for="inputDescripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="inputDescripcion" name="descripcion" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="submitButton">Crear Permiso</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Eliminar Permiso -->
<div class="modal fade" id="modalEliminarPermiso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Permiso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?php echo BASE_URL; ?>permisos/eliminar_permiso.php" method="POST">
                <input type="hidden" id="eliminarId" name="id">
                <div class="modal-body">
                    <p>¿Está seguro que desea eliminar el permiso <strong id="permisoEliminar"></strong>?</p>
                    <p class="text-danger">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar Permiso</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script para manejar los modales -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal único para crear/editar
    const modalPermiso = document.getElementById('modalPermiso');
    if (modalPermiso) {
        modalPermiso.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const mode = button.getAttribute('data-mode');
            const form = document.getElementById('formPermiso');
            const title = document.getElementById('modalPermisoTitle');
            const submitButton = document.getElementById('submitButton');
            
            if (mode === 'edit') {
                // Modo edición
                const id = button.getAttribute('data-id');
                const nombre = button.getAttribute('data-nombre');
                const descripcion = button.getAttribute('data-descripcion');
                
                document.getElementById('permisoId').value = id;
                document.getElementById('inputNombre').value = nombre;
                document.getElementById('inputDescripcion').value = descripcion;
                document.getElementById('formMode').value = 'edit';
                
                // Cambiar textos
                title.textContent = 'Editar Permiso';
                submitButton.textContent = 'Guardar Cambios';
            } else {
                // Modo creación
                document.getElementById('formMode').value = 'create';
                form.reset();
                document.getElementById('permisoId').value = '';
                
                // Cambiar textos
                title.textContent = 'Crear Nuevo Permiso';
                submitButton.textContent = 'Crear Permiso';
            }
        });
    }
    
    // Modal de eliminación
    const modalEliminar = document.getElementById('modalEliminarPermiso');
    if (modalEliminar) {
        modalEliminar.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nombre = button.getAttribute('data-nombre');
            
            modalEliminar.querySelector('#eliminarId').value = id;
            modalEliminar.querySelector('#permisoEliminar').textContent = nombre;
        });
    }
});
</script>
</body>
</html>