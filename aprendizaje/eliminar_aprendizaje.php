<?php
// eliminar_contenido.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';

include_once HOME_PATH . 'verificar_sesion.php';
include_once HOME_PATH . 'cx/peticiones.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    
    if (empty($id)) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'ID de contenido no válido.'
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    
    try {
        $resultado = eliminarRegistro('materia_metodo_aprendizaje', $id);
        
        if (isset($resultado['error'])) {
            throw new Exception($resultado['error']);
        }
        
        $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'texto' => 'Contenido eliminado correctamente.'
        ];
        
    } catch (Exception $e) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'Error al eliminar el contenido: ' . $e->getMessage()
        ];
    }
    
    header('Location: ' . BASE_URL . 'dashboard.php?seccion=aprendizaje');
    exit;
} else {
    header('Location: ' . BASE_URL . 'dashboard.php');
    exit;
}