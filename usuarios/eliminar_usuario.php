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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    
    // En lugar de eliminar físicamente, marcamos como inactivo
    $datosActualizar = ['estado' => 2]; // 2 = Inactivo
    $resultado = actualizarRegistro('usuario', $id, $datosActualizar);
    
    if (isset($resultado['error'])) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => $resultado['error']
        ];
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'texto' => 'Usuario desactivado correctamente'
        ];
    }
    
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
?>