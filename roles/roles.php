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

// Obtener todos los roles
$roles = listarRegistros('roles');

// Si hay error, mostrarlo
if (isset($roles['error'])) {
    echo '<div class="alert alert-danger">Error: ' . $roles['error'] . '</div>';
    $roles = [];
}

// Obtener todos los permisos para usar en el modal
$permisos = listarRegistros('permisos');
if (isset($permisos['error'])) {
    $permisos = [];
}

// Función para obtener los permisos de un rol específico
function obtenerPermisosRol($rol_id) {
    $query = "SELECT permiso_id FROM roles_x_permiso WHERE rol_id = ?";
    $resultado = peticionSQL($query, [$rol_id], true);
    
    $permisos = [];
    if (!isset($resultado['error']) && is_array($resultado)) {
        foreach ($resultado as $fila) {
            $permisos[] = $fila['permiso_id'];
        }
    }
    return $permisos;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="<?php echo BASE_URL; ?>estilos_bo/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/dashboard.css">
    <link rel="icon" href="<?php echo BASE_URL; ?>logo/cerebro.svg" type="image/x-icon">
</head>
<body>
<!-- Roles Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Lista de Roles</span>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalRol" data-mode="create">
            <i class="fas fa-plus me-1"></i> Nuevo Rol
        </button>
    </div>
    <div class="card-body">
        <?php if (empty($roles)): ?>
            <div class="alert alert-info">
                No hay roles registrados en el sistema.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Permisos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($roles as $rol): 
                            $permisosRol = obtenerPermisosRol($rol['id']);
                        ?>
                            <tr>
                                <td><?php echo $rol['id']; ?></td>
                                <td><?php echo htmlspecialchars($rol['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($rol['descripcion'] ?? 'Sin descripción'); ?></td>
                                <td>
                                    <?php if (!empty($permisosRol)): ?>
                                        <span class="badge bg-info"><?php echo count($permisosRol); ?> permisos</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Sin permisos</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary action-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalRol"
                                            data-mode="edit"
                                            data-id="<?php echo $rol['id']; ?>"
                                            data-nombre="<?php echo htmlspecialchars($rol['nombre']); ?>"
                                            data-descripcion="<?php echo htmlspecialchars($rol['descripcion'] ?? ''); ?>"
                                            data-permisos="<?php echo htmlspecialchars(implode(',', $permisosRol)); ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger action-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEliminarRol"
                                            data-id="<?php echo $rol['id']; ?>"
                                            data-nombre="<?php echo htmlspecialchars($rol['nombre']); ?>">
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

<!-- Modal único para Crear/Editar Rol -->
<div class="modal fade" id="modalRol" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRolTitle">Crear Nuevo Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo BASE_URL; ?>roles/guardar_rol.php" method="POST" id="formRol">
                <input type="hidden" id="rolId" name="id">
                <input type="hidden" id="formMode" name="mode" value="create">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inputNombre" class="form-label">Nombre del Rol</label>
                                <input type="text" class="form-control" id="inputNombre" name="nombre" required>
                                <div class="form-text">El nombre debe ser único (ej: Administrador, Editor, Usuario)</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inputDescripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="inputDescripcion" name="descripcion" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Permisos</label>
                        <div class="border p-3 rounded" style="max-height: 200px; overflow-y: auto;">
                            <?php if (!empty($permisos)): ?>
                                <?php foreach ($permisos as $permiso): ?>
                                    <div class="form-check">
                                        <input class="form-check-input permiso-checkbox" type="checkbox" 
                                               name="permisos[]" value="<?php echo $permiso['id']; ?>" 
                                               id="permiso-<?php echo $permiso['id']; ?>">
                                        <label class="form-check-label" for="permiso-<?php echo $permiso['id']; ?>">
                                            <?php echo htmlspecialchars($permiso['nombre']); ?>
                                            <?php if (!empty($permiso['descripcion'])): ?>
                                                <small class="text-muted">- <?php echo htmlspecialchars($permiso['descripcion']); ?></small>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-warning">No hay permisos disponibles</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="submitButton">Crear Rol</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Eliminar Rol -->
<div class="modal fade" id="modalEliminarRol" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label='Close'></button>
            </div>

            <form action="<?php echo BASE_URL; ?>roles/eliminar_rol.php" method="POST">
                <input type="hidden" id="eliminarId" name="id">
                <div class="modal-body">
                    <p>¿Está seguro que desea eliminar el rol <strong id="rolEliminar"></strong>?</p>
                    <p class="text-danger">Esta acción eliminará también todas las asignaciones de permisos asociadas a este rol.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar Rol</button>
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
    const modalRol = document.getElementById('modalRol');
    if (modalRol) {
        modalRol.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const mode = button.getAttribute('data-mode');
            const form = document.getElementById('formRol');
            const title = document.getElementById('modalRolTitle');
            const submitButton = document.getElementById('submitButton');
            
            // Desmarcar todos los checkboxes primero
            document.querySelectorAll('.permiso-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
            
            if (mode === 'edit') {
                // Modo edición
                const id = button.getAttribute('data-id');
                const nombre = button.getAttribute('data-nombre');
                const descripcion = button.getAttribute('data-descripcion');
                const permisos = button.getAttribute('data-permisos').split(',');
                
                document.getElementById('rolId').value = id;
                document.getElementById('inputNombre').value = nombre;
                document.getElementById('inputDescripcion').value = descripcion;
                document.getElementById('formMode').value = 'edit';
                
                // Marcar los checkboxes de permisos
                if (permisos.length > 0 && permisos[0] !== '') {
                    permisos.forEach(permisoId => {
                        const checkbox = document.getElementById('permiso-' + permisoId);
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    });
                }
                
                // Cambiar textos
                title.textContent = 'Editar Rol';
                submitButton.textContent = 'Guardar Cambios';
            } else {
                // Modo creación
                document.getElementById('formMode').value = 'create';
                form.reset();
                document.getElementById('rolId').value = '';
                
                // Cambiar textos
                title.textContent = 'Crear Nuevo Rol';
                submitButton.textContent = 'Crear Rol';
            }
        });
    }
    
    // Modal de eliminación
    const modalEliminar = document.getElementById('modalEliminarRol');
    if (modalEliminar) {
        modalEliminar.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nombre = button.getAttribute('data-nombre');
            
            modalEliminar.querySelector('#eliminarId').value = id;
            modalEliminar.querySelector('#rolEliminar').textContent = nombre;
        });
    }
});
</script>
</body>
</html>