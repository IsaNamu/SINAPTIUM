<?php
session_start();
include_once './cx/peticiones.php';

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