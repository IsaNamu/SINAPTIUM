<?php
// guardar_libro.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';

include_once HOME_PATH . 'verificar_sesion.php';
include_once HOME_PATH . 'cx/peticiones.php';

// Configuración para subida de archivos
$upload_dir_pdf = HOME_PATH . 'biblioteca/pdfs/';
$upload_dir_imagen = HOME_PATH . 'biblioteca/imagenes/';
$max_file_size_pdf = 10 * 1024 * 1024; // 10MB
$max_file_size_imagen = 5 * 1024 * 1024; // 5MB

// Aumentar límites de PHP para subida de archivos grandes
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '12M');
ini_set('max_execution_time', 300);

// Crear directorios si no existen
if (!file_exists($upload_dir_pdf)) {
    mkdir($upload_dir_pdf, 0777, true);
}
if (!file_exists($upload_dir_imagen)) {
    mkdir($upload_dir_imagen, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $titulo = trim($_POST['titulo'] ?? '');
    $enlace = trim($_POST['enlace'] ?? '');
    $imagen_url = trim($_POST['imagen_url'] ?? '');
    $archivo_pdf_url = trim($_POST['archivo_pdf_url'] ?? '');
    $autor_id = $_POST['autor_id'] ?? null;
    $categoria_id = $_POST['categoria_id'] ?? null;
    $nuevo_autor_nombre = trim($_POST['nuevo_autor_nombre'] ?? '');
    $mode = $_POST['mode'] ?? 'create';
    
    // Validaciones básicas
    if (empty($titulo)) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'El título es obligatorio.'
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    
    // Validar que al menos tenga enlace o archivo PDF (solo en creación)
    if ($mode === 'create') {
        $tiene_enlace = !empty($enlace) || !empty($archivo_pdf_url);
        $tiene_archivo = isset($_FILES['archivo_pdf']) && !empty($_FILES['archivo_pdf']['name']);
        
        if (!$tiene_enlace && !$tiene_archivo) {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Debe proporcionar al menos un enlace o subir un archivo PDF.'
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
    
    // Manejar nuevo autor si se seleccionó "Otro"
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
        
        $autor_id = $resultado_autor['id'];
    } elseif ($autor_id === 'otro' && empty($nuevo_autor_nombre)) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'Debe especificar el nombre del autor cuando selecciona "Otro".'
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    
    // Manejar subida de imagen
    $imagen_final = $imagen_url; // Por defecto usar la URL
    
    if (isset($_FILES['imagen_archivo']) && !empty($_FILES['imagen_archivo']['name'])) {
        $imagen_name = $_FILES['imagen_archivo']['name'];
        $imagen_tmp = $_FILES['imagen_archivo']['tmp_name'];
        $imagen_size = $_FILES['imagen_archivo']['size'];
        $imagen_error = $_FILES['imagen_archivo']['error'];
        
        // Validar que se haya subido correctamente
        if ($imagen_error !== UPLOAD_ERR_OK) {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Error al subir la imagen: ' . $imagen_error
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        
        // Validar tipo de archivo de imagen
        $allowed_image_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $imagen_ext = strtolower(pathinfo($imagen_name, PATHINFO_EXTENSION));
        if (!in_array($imagen_ext, $allowed_image_types)) {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Solo se permiten archivos de imagen (JPG, PNG, GIF, WEBP).'
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        
        // Validar tamaño
        if ($imagen_size > $max_file_size_imagen) {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'La imagen excede el tamaño máximo permitido (5MB).'
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        
        // Generar nombre único
        $new_imagen_name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $imagen_name);
        $imagen_destination = $upload_dir_imagen . $new_imagen_name;
        
        if (move_uploaded_file($imagen_tmp, $imagen_destination)) {
            $imagen_final = BASE_URL . 'biblioteca/imagenes/' . $new_imagen_name;
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Error al guardar la imagen en el servidor.'
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
    
    // Manejar subida de archivo PDF
    $archivo_pdf_final = $archivo_pdf_url; // Por defecto usar la URL
    
    if (isset($_FILES['archivo_pdf']) && !empty($_FILES['archivo_pdf']['name'])) {
        $file_name = $_FILES['archivo_pdf']['name'];
        $file_tmp = $_FILES['archivo_pdf']['tmp_name'];
        $file_size = $_FILES['archivo_pdf']['size'];
        $file_error = $_FILES['archivo_pdf']['error'];
        
        // Validar que se haya subido correctamente
        if ($file_error !== UPLOAD_ERR_OK) {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Error al subir el archivo: ' . $file_error
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        
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
        if ($file_size > $max_file_size_pdf) {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'El archivo excede el tamaño máximo permitido (10MB).'
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        
        // Generar nombre único
        $new_file_name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file_name);
        $file_destination = $upload_dir_pdf . $new_file_name;
        
        if (move_uploaded_file($file_tmp, $file_destination)) {
            $archivo_pdf_final = BASE_URL . 'biblioteca/pdfs/' . $new_file_name;
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Error al guardar el archivo en el servidor.'
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
    
    // Preparar datos del libro - Asegurar que campos obligatorios tengan valores por defecto
    $datos_libro = [
        'titulo' => $titulo,
        'enlace' => empty($enlace) ? '' : $enlace,
        'imagen' => $imagen_final,
        'autor_id' => ($autor_id === 'otro' || empty($autor_id)) ? null : $autor_id,
        'categoria_id' => empty($categoria_id) ? null : $categoria_id
    ];
    
    // Agregar archivo PDF solo si se tiene uno
    if (!empty($archivo_pdf_final)) {
        $datos_libro['archivo_pdf'] = $archivo_pdf_final;
    }
    
    // Si estamos en modo edición, mantener los valores existentes para campos no proporcionados
    if ($mode === 'edit' && !empty($id)) {
        // Obtener libro actual para preservar valores existentes
        $libro_actual = peticionSQL("SELECT * FROM biblioteca WHERE id = ?", [$id], false);
        
        if ($libro_actual && !isset($libro_actual['error'])) {
            // Preservar enlace existente si no se proporciona uno nuevo
            if (empty($enlace) && empty($archivo_pdf_url) && !isset($_FILES['archivo_pdf']) && isset($libro_actual['enlace'])) {
                $datos_libro['enlace'] = $libro_actual['enlace'];
            }
            
            // Preservar archivo PDF existente si no se sube uno nuevo ni se proporciona URL
            if (empty($archivo_pdf_final) && isset($libro_actual['archivo_pdf'])) {
                $datos_libro['archivo_pdf'] = $libro_actual['archivo_pdf'];
            }
            
            // Preservar imagen existente si no se proporciona una nueva
            if (empty($imagen_final) && isset($libro_actual['imagen'])) {
                $datos_libro['imagen'] = $libro_actual['imagen'];
            }
        }
    }
    
    // Eliminar campos nulos pero mantener campos vacíos necesarios
    $datos_libro = array_filter($datos_libro, function($value) {
        return $value !== null;
    });
    
    // Asegurar que los campos obligatorios estén presentes
    if (!isset($datos_libro['enlace'])) {
        $datos_libro['enlace'] = ''; // Valor por defecto para enlace
    }
    
    try {
        if ($mode === 'edit' && !empty($id)) {
            $resultado = actualizarRegistro('biblioteca', $id, $datos_libro);
            $accion = 'actualizado';
        } else {
            $resultado = insertarRegistro('biblioteca', $datos_libro);
            $accion = 'creado';
        }
        
        if (isset($resultado['error'])) {
            throw new Exception($resultado['error']);
        }
        
        $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'texto' => 'Libro ' . $accion . ' correctamente.'
        ];
        
    } catch (Exception $e) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'Error al ' . $accion . ' el libro: ' . $e->getMessage()
        ];
    }
    
    header('Location: ' . BASE_URL . 'dashboard.php?seccion=biblioteca');
    exit;
}