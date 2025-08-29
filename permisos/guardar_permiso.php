<?php
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
define('HOME_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');

include_once HOME_PATH . 'cx/peticiones.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion'] ?? '');
    $mode = $_POST['mode'] ?? 'create';
    
    // Validaciones básicas
    if (empty($nombre)) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'El nombre del permiso es obligatorio.'
        ];
        header('Location: ' . BASE_URL . 'dashboard.php?seccion=permisos');
        exit;
    }
    
    // Preparar datos
    $datos = [
        'nombre' => $nombre,
        'descripcion' => $descripcion
    ];
    
    if ($mode === 'edit' && !empty($id)) {
        // Modo edición
        $resultado = actualizarRegistro('permisos', $id, $datos);
        $accion = 'actualizado';
    } else {
        // Modo creación
        $resultado = insertarRegistro('permisos', $datos);
        $accion = 'creado';
    }
    
    if (isset($resultado['error'])) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'Error al ' . $accion . ' el permiso: ' . $resultado['error']
        ];
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'texto' => 'Permiso ' . $accion . ' correctamente.'
        ];
    }
}

header('Location: ' . BASE_URL . 'dashboard.php?seccion=permisos');
exit;