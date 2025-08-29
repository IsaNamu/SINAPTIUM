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

include_once HOME_PATH . 'verificar_sesion.php';
include_once HOME_PATH . 'cx/peticiones.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion'] ?? '');
    $permisos = $_POST['permisos'] ?? [];
    $mode = $_POST['mode'] ?? 'create';
    
    // Validaciones básicas
    if (empty($nombre)) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'El nombre del rol es obligatorio.'
        ];
        header('Location: ' . BASE_URL . 'dashboard.php?seccion=roles');
        exit;
    }
    
    // Preparar datos
    $datos = [
        'nombre' => $nombre,
        'descripcion' => $descripcion
    ];
    
    if ($mode === 'edit' && !empty($id)) {
        // Modo edición
        $resultado = actualizarRegistro('roles', $id, $datos);
        $accion = 'actualizado';
        $rol_id = $id;
    } else {
        // Modo creación
        $resultado = insertarRegistro('roles', $datos);
        $accion = 'creado';
        $rol_id = $resultado['id'] ?? null;
    }
    
    if (isset($resultado['error'])) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'Error al ' . $accion . ' el rol: ' . $resultado['error']
        ];
    } else {
        // Gestionar permisos si el rol se creó/actualizó correctamente
        if ($rol_id) {
            // Eliminar permisos actuales
            $eliminarQuery = "DELETE FROM roles_x_permiso WHERE rol_id = ?";
            peticionSQL($eliminarQuery, [$rol_id]);
            
            // Insertar nuevos permisos
            if (!empty($permisos)) {
                foreach ($permisos as $permiso_id) {
                    $insertarQuery = "INSERT INTO roles_x_permiso (rol_id, permiso_id) VALUES (?, ?)";
                    peticionSQL($insertarQuery, [$rol_id, $permiso_id]);
                }
            }
        }
        
        $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'texto' => 'Rol ' . $accion . ' correctamente.'
        ];
    }
}

header('Location: ' . BASE_URL . 'dashboard.php?seccion=roles');
exit;