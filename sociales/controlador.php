<?php
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
    
    // Obtener el ID del método de aprendizaje desde la base de datos
    $sql = "SELECT id FROM metodos_aprendizaje WHERE nombre = ?";
    $stmt = $conexion->prepare($sql);
    
    // Ajustar el nombre para la base de datos
    $nombreMetodo = ($tipoAprendizaje === 'kinestesico') ? 'kinestésico' : $tipoAprendizaje;
    
    $stmt->bind_param("s", $nombreMetodo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        die(json_encode(['success' => false, 'message' => 'Método de aprendizaje no encontrado en la base de datos']));
    }
    
    $metodoAprendizaje = $result->fetch_assoc();
    $metodo_id = $metodoAprendizaje['id'];
    
    // Preparar datos para actualizar
    $datosActualizacion = [
        'metodo_aprendizaje_id' => $metodo_id
    ];
    
    // Usar tu método actualizarRegistro
    $resultado = actualizarRegistro('usuario', $usuario_id, $datosActualizacion, 'id');
    
    if (isset($resultado['success']) && $resultado['success']) {
        // Actualizar las variables de sesión
        $_SESSION['aprendizaje'] = $tipoAprendizaje;
        $_SESSION['metodo_aprendizaje_id'] = $metodo_id;
        
        echo json_encode([
            'success' => true, 
            'message' => 'Estilo de aprendizaje actualizado correctamente',
            'tipoAprendizaje' => $tipoAprendizaje,
            'metodo_id' => $metodo_id
        ]);
    } else {
        $error = isset($resultado['error']) ? $resultado['error'] : 'Error desconocido';
        echo json_encode(['success' => false, 'message' => $error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>