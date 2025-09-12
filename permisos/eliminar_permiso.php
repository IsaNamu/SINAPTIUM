<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';

// Includes (para el servidor)
include_once HOME_PATH . 'verificar_sesion.php';
include_once HOME_PATH . 'cx/peticiones.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    
    if (empty($id)) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'ID de permiso no válido.'
        ];
        header('Location: ' . BASE_URL . 'dashboard.php?seccion=permisos');
        exit;
    }
    
    $resultado = eliminarRegistro('permisos', $id);
    
    if (isset($resultado['error'])) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'Error al eliminar el permiso: ' . $resultado['error']
        ];
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'texto' => 'Permiso eliminado correctamente.'
        ];
    }
}

header('Location: ' . BASE_URL . 'dashboard.php?seccion=permisos');
exit;