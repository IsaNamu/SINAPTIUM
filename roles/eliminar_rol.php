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
    
    if (empty($id)) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'ID de rol no válido.'
        ];
        header('Location: ' . BASE_URL . 'dashboard.php?seccion=roles');
        exit;
    }
    
    // Primero eliminar las relaciones en roles_x_permiso
    $eliminarPermisosQuery = "DELETE FROM roles_x_permiso WHERE rol_id = ?";
    peticionSQL($eliminarPermisosQuery, [$id]);
    
    // Luego eliminar el rol
    $resultado = eliminarRegistro('roles', $id);
    
    if (isset($resultado['error'])) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'Error al eliminar el rol: ' . $resultado['error']
        ];
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'texto' => 'Rol eliminado correctamente.'
        ];
    }
}

header('Location: ' . BASE_URL . 'dashboard.php?seccion=roles');
exit;