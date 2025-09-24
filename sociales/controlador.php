<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';
include_once HOME_PATH . 'cx/peticiones.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    die(json_encode(['success' => false, 'message' => 'Usuario no autenticado']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $usuario_id = $_SESSION['usuario_id'];
    $tipoAprendizaje = isset($_POST['tipoAprendizaje']) ? $_POST['tipoAprendizaje'] : '';
    
    // Validar el tipo de aprendizaje
    $tiposPermitidos = ['visual', 'auditivo', 'kinestesico'];
    if (!in_array($tipoAprendizaje, $tiposPermitidos)) {
        die(json_encode(['success' => false, 'message' => 'Tipo de aprendizaje no válido']));
    }
    
    // Ajustar el tipo para que coincida con el ENUM de la base de datos
    if ($tipoAprendizaje === 'kinestesico') {
        $tipoAprendizajeDB = 'kinestésico';
    } else {
        $tipoAprendizajeDB = $tipoAprendizaje;
    }
    
    // Preparar datos para actualizar
    $datosActualizacion = [
        'aprendizaje' => $tipoAprendizajeDB
    ];
    
    // Usar tu método actualizarRegistro
    $resultado = actualizarRegistro('usuario', $usuario_id, $datosActualizacion, 'id');
    
    if (isset($resultado['success']) && $resultado['success']) {
        // Actualizar la variable de sesión
        $_SESSION['aprendizaje'] = $tipoAprendizaje;
        
        echo json_encode([
            'success' => true, 
            'message' => 'Estilo de aprendizaje actualizado correctamente',
            'tipoAprendizaje' => $tipoAprendizaje
        ]);
    } else {
        $error = isset($resultado['error']) ? $resultado['error'] : 'Error desconocido';
        echo json_encode(['success' => false, 'message' => $error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>