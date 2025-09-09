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

// Configuración para subida de archivos
$upload_dir = HOME_PATH . 'pdfs/';
$max_file_size = 10 * 1024 * 1024; // 10MB

// Crear directorio si no existe
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $titulo = trim($_POST['titulo'] ?? '');
    $enlace = trim($_POST['enlace'] ?? '');
    $imagen = trim($_POST['imagen'] ?? '');
    $autor_id = $_POST['autor_id'] ?? null;
    $categoria_id = $_POST['categoria_id'] ?? null;
    $nuevo_autor_nombre = trim($_POST['nuevo_autor_nombre'] ?? '');
    $mode = $_POST['mode'] ?? 'create';
    
    // Validaciones básicas - Solo título obligatorio
    if (empty($titulo)) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'El título es obligatorio.'
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    
    // Validar que al menos tenga enlace o archivo PDF
    $tiene_enlace = !empty($enlace);
    $tiene_archivo = !empty($_FILES['archivo_pdf']['name']);
    
    if (!$tiene_enlace && !$tiene_archivo) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'Debe proporcionar al menos un enlace o subir un archivo PDF.'
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    
    // Si se seleccionó "Otro" y se proporcionó un nombre
    if ($autor_id === 'otro' && !empty($nuevo_autor_nombre)) {
        // Insertar nuevo autor
        $datos_autor = ['nombre' => $nuevo_autor_nombre];
        $resultado_autor = insertarRegistro('autores', $datos_autor);
        
        if (isset($resultado_autor['error'])) {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Error al crear el autor: ' . $resultado_autor['error']
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        
        // Usar el ID del nuevo autor
        $autor_id = $resultado_autor['id'];
    }
    
    // Manejar subida de archivo PDF
    $archivo_pdf = '';
    if ($tiene_archivo) {
        $file_name = $_FILES['archivo_pdf']['name'];
        $file_tmp = $_FILES['archivo_pdf']['tmp_name'];
        $file_size = $_FILES['archivo_pdf']['size'];
        $file_error = $_FILES['archivo_pdf']['error'];
        
        // Validar tipo de archivo
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if ($file_ext !== 'pdf') {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Solo se permiten archivos PDF.'
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        
        // Validar tamaño
        if ($file_size > $max_file_size) {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'El archivo excede el tamaño máximo permitido (10MB).'
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        
        // Generar nombre único
        $new_file_name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file_name);
        $file_destination = $upload_dir . $new_file_name;
        
        if (move_uploaded_file($file_tmp, $file_destination)) {
            $archivo_pdf = BASE_URL . 'pdfs/' . $new_file_name;
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Error al subir el archivo.'
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
    
    // Preparar datos del libro
    $datos_libro = [
        'titulo' => $titulo,
        'enlace' => $enlace,
        'imagen' => $imagen,
        'autor_id' => $autor_id,
        'categoria_id' => $categoria_id
    ];
    
    // Agregar archivo PDF solo si se subió uno
    if (!empty($archivo_pdf)) {
        $datos_libro['archivo_pdf'] = $archivo_pdf;
    }
    
    if ($mode === 'edit' && !empty($id)) {
        $resultado = actualizarRegistro('biblioteca', $id, $datos_libro);
        $accion = 'actualizado';
    } else {
        $resultado = insertarRegistro('biblioteca', $datos_libro);
        $accion = 'creado';
    }
    
    if (isset($resultado['error'])) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'Error al ' . $accion . ' el libro: ' . $resultado['error']
        ];
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'texto' => 'Libro ' . $accion . ' correctamente.'
        ];
    }
}

header('Location: ' . BASE_URL . 'dashboard.php?seccion=biblioteca');
exit;