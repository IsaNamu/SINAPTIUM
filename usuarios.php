<?php
include_once './cx/peticiones.php';

// Obtener todos los usuarios
$usuarios = listarRegistros('usuario');

// Si hay error, mostrarlo
if (isset($usuarios['error'])) {
    echo '<div class="alert alert-danger">Error: ' . $usuarios['error'] . '</div>';
    $usuarios = [];
}

// Obtener los roles para mostrar los nombres en lugar de IDs
$roles = listarRegistros('roles');
$rolesMap = [];
if (!isset($roles['error'])) {
    foreach ($roles as $rol) {
        $rolesMap[$rol['id']] = $rol['nombre'];
    }
} else {
    // Si hay error al obtener roles, usar un mapa vacío
    $rolesMap = [];
}

// Determinar si estamos en modo edición
$modoEdicion = false;
$usuarioEditar = null;
if (isset($_GET['editar'])) {
    $modoEdicion = true;
    // Aquí iría la lógica para obtener los datos del usuario a editar
    // $usuarioEditar = obtenerUsuarioPorId($_GET['editar']);
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="estilos_bo/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="icon" href="logo/cerebro.svg" type="image/x-icon">
</head>
<body>
<!-- Users Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Lista de Usuarios</span>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalUsuario" data-mode="create">
            <i class="fas fa-plus me-1"></i> Nuevo Usuario
        </button>
    </div>
    <div class="card-body">
        <?php if (empty($usuarios)): ?>
            <div class="alert alert-info">
                No hay usuarios registrados en el sistema.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <?php
                            // Determinar clase del badge según el rol
                            $rolBadgeClass = 'bg-secondary'; // Por defecto
                            if (isset($rolesMap[$usuario['rol_id']])) {
                                $rolNombre = strtolower($rolesMap[$usuario['rol_id']]);
                                if (strpos($rolNombre, 'admin') !== false) {
                                    $rolBadgeClass = 'bg-primary';
                                } elseif (strpos($rolNombre, 'editor') !== false) {
                                    $rolBadgeClass = 'bg-info';
                                } elseif (strpos($rolNombre, 'estudiante') !== false) {
                                    $rolBadgeClass = 'bg-success';
                                } elseif (strpos($rolNombre, 'instructor') !== false) {
                                    $rolBadgeClass = 'bg-warning';
                                }
                            }
                            
                            // Determinar estado (asumiendo que hay un campo 'activo' o 'estado')
                            $estado = 'Activo';
                            $estadoBadgeClass = 'badge-success';
                            
                            if (isset($usuario['activo']) && $usuario['activo'] == 0) {
                                $estado = 'Inactivo';
                                $estadoBadgeClass = 'badge-warning';
                            } elseif (isset($usuario['estado'])) {
                                $estado = $usuario['estado'];
                                if ($estado == 'Inactivo') {
                                    $estadoBadgeClass = 'badge-warning';
                                } elseif ($estado == 'Bloqueado') {
                                    $estadoBadgeClass = 'badge-danger';
                                }
                            }
                            
                            // Formatear fecha de registro
                            $fechaRegistro = '';
                            if (isset($usuario['fecha_creacion'])) {
                                $fechaRegistro = date('Y-m-d', strtotime($usuario['fecha_creacion']));
                            } elseif (isset($usuario['created_at'])) {
                                $fechaRegistro = date('Y-m-d', strtotime($usuario['created_at']));
                            }
                            ?>
                            <tr>
                                <td><?php echo $usuario['id']; ?></td>
                                <td><?php echo htmlspecialchars($usuario['usuario']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                                <td>
                                    <span class="badge <?php echo $rolBadgeClass; ?>">
                                        <?php 
                                        echo isset($rolesMap[$usuario['rol_id']]) 
                                            ? htmlspecialchars($rolesMap[$usuario['rol_id']]) 
                                            : 'Rol ' . $usuario['rol_id'];
                                        ?>
                                    </span>
                                </td>
                                <td><span class="badge <?php echo $estadoBadgeClass; ?>"><?php echo $estado; ?></span></td>
                                <td><?php echo $fechaRegistro; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary action-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalUsuario"
                                            data-mode="edit"
                                            data-id="<?php echo $usuario['id']; ?>"
                                            data-usuario="<?php echo htmlspecialchars($usuario['usuario']); ?>"
                                            data-correo="<?php echo htmlspecialchars($usuario['correo']); ?>"
                                            data-rol="<?php echo $usuario['rol_id']; ?>"
                                            data-activo="<?php echo isset($usuario['activo']) ? $usuario['activo'] : 1; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger action-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEliminarUsuario"
                                            data-id="<?php echo $usuario['id']; ?>"
                                            data-usuario="<?php echo htmlspecialchars($usuario['usuario']); ?>">
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

<!-- Modal único para Crear/Editar Usuario -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUsuarioTitle">Crear Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="guardar_usuario.php" method="POST" id="formUsuario">
                <input type="hidden" id="usuarioId" name="id">
                <input type="hidden" id="formMode" name="mode" value="create">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputUsuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="inputUsuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputCorreo" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="inputCorreo" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputPassword" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="inputPassword" name="password">
                        <div class="form-text" id="passwordHelp">Requerida para nuevos usuarios</div>
                    </div>
                    <div class="mb-3">
                        <label for="selectRol" class="form-label">Rol</label>
                        <select class="form-select" id="selectRol" name="rol_id" required>
                            <option value="">Seleccionar rol</option>
                            <?php foreach ($roles as $rol): ?>
                                <option value="<?php echo $rol['id']; ?>"><?php echo htmlspecialchars($rol['nombre']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3" id="estadoContainer">
                        <label class="form-label">Estado</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="activo" id="estadoActivo" value="1" checked>
                                <label class="form-check-label" for="estadoActivo">Activo</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="activo" id="estadoInactivo" value="0">
                                <label class="form-check-label" for="estadoInactivo">Inactivo</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="submitButton">Crear Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Eliminar Usuario -->
<div class="modal fade" id="modalEliminarUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="eliminar_usuario.php" method="POST">
                <input type="hidden" id="eliminarId" name="id">
                <div class="modal-body">
                    <p>¿Está seguro que desea eliminar al usuario <strong id="usuarioEliminar"></strong>?</p>
                    <p class="text-danger">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar Usuario</button>
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
    const modalUsuario = document.getElementById('modalUsuario');
    if (modalUsuario) {
        modalUsuario.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const mode = button.getAttribute('data-mode');
            const form = document.getElementById('formUsuario');
            const title = document.getElementById('modalUsuarioTitle');
            const submitButton = document.getElementById('submitButton');
            const passwordInput = document.getElementById('inputPassword');
            const passwordHelp = document.getElementById('passwordHelp');
            const estadoContainer = document.getElementById('estadoContainer');
            
            if (mode === 'edit') {
                // Modo edición
                const id = button.getAttribute('data-id');
                const usuario = button.getAttribute('data-usuario');
                const correo = button.getAttribute('data-correo');
                const rol = button.getAttribute('data-rol');
                const activo = button.getAttribute('data-activo');
                
                document.getElementById('usuarioId').value = id;
                document.getElementById('inputUsuario').value = usuario;
                document.getElementById('inputCorreo').value = correo;
                document.getElementById('selectRol').value = rol;
                document.getElementById('formMode').value = 'edit';
                
                // Seleccionar el estado correcto
                if (activo === '1') {
                    document.getElementById('estadoActivo').checked = true;
                } else {
                    document.getElementById('estadoInactivo').checked = true;
                }
                
                // Cambiar textos
                title.textContent = 'Editar Usuario';
                submitButton.textContent = 'Guardar Cambios';
                passwordInput.required = false;
                passwordHelp.textContent = 'Dejar vacío para mantener la contraseña actual';
                estadoContainer.style.display = 'block';
                
                // Cambiar acción del formulario si es necesario
                form.action = 'actualizar_usuario.php';
            } else {
                // Modo creación
                document.getElementById('formMode').value = 'create';
                form.reset();
                document.getElementById('usuarioId').value = '';
                
                // Cambiar textos
                title.textContent = 'Crear Nuevo Usuario';
                submitButton.textContent = 'Crear Usuario';
                passwordInput.required = true;
                passwordHelp.textContent = 'Requerida para nuevos usuarios';
                estadoContainer.style.display = 'none';
                
                // Asegurar que el formulario apunte a la acción correcta
                form.action = 'guardar_usuario.php';
            }
        });
    }
    
    // Modal de eliminación
    const modalEliminar = document.getElementById('modalEliminarUsuario');
    if (modalEliminar) {
        modalEliminar.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const usuario = button.getAttribute('data-usuario');
            
            modalEliminar.querySelector('#eliminarId').value = id;
            modalEliminar.querySelector('#usuarioEliminar').textContent = usuario;
        });
    }
});
</script>
</body>