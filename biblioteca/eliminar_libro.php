<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';

include_once HOME_PATH . 'verificar_sesion.php';
include_once HOME_PATH . 'cx/peticiones.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    
    if (!$id) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'ID de libro no proporcionado.'
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    
    $query = "DELETE FROM biblioteca WHERE id = ?";
    $resultado = peticionSQL($query, [$id]);
    
    if (isset($resultado['error'])) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'Error: ' . $resultado['error']
        ];
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'texto' => 'Libro eliminado correctamente.'
        ];
    }
    
    header('Location: ../biblioteca.php');
    header('Location: ' . BASE_URL . 'dashboard.php?seccion=biblioteca');
    exit;
}