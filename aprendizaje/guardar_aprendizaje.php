<?php
// PRIMERO: Configurar límites - esto debe ser lo ABSOLUTAMENTE PRIMERO
ini_set('upload_max_filesize', '20M');
ini_set('post_max_size', '22M');
ini_set('max_execution_time', 300);
ini_set('max_input_time', 300);
ini_set('memory_limit', '256M');

// SEGUNDO: Iniciar output buffering para evitar errores de headers
ob_start();

// TERCERO: Incluir archivos de configuración
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';

include_once HOME_PATH . 'verificar_sesion.php';
include_once HOME_PATH . 'cx/peticiones.php';

// Configuración para subida de archivos
$upload_dir_imagen = HOME_PATH . 'contenidos/imagenes/';
$upload_dir_archivos = HOME_PATH . 'contenidos/archivos/';
$max_file_size_archivo = 10 * 1024 * 1024; // 10MB
$max_file_size_imagen = 5 * 1024 * 1024; // 5MB

// Crear directorios si no existen
if (!file_exists($upload_dir_imagen)) {
    mkdir($upload_dir_imagen, 0777, true);
}
if (!file_exists($upload_dir_archivos)) {
    mkdir($upload_dir_archivos, 0777, true);
}

// Restricciones por método de aprendizaje
$restriccionesMetodos = [
    'kinestésico' => ['video', 'interactivo', 'enlace'],
    'auditivo' => ['audio', 'documento', 'enlace'],
    'visual' => ['imagen', 'video', 'documento', 'enlace']
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si el POST está vacío (indicaría que excedió el límite)
    if (empty($_POST) && empty($_FILES)) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'El archivo es demasiado grande. Tamaño máximo: ' . ini_get('post_max_size')
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        ob_end_flush();
        exit;
    }
    
    $id = $_POST['id'] ?? null;
    $materia_id = $_POST['materia_id'] ?? null;
    $metodo_aprendizaje_id = $_POST['metodo_aprendizaje_id'] ?? null;
    $contenido = trim($_POST['contenido'] ?? '');
    $tipo = $_POST['tipo'] ?? '';
    $imagen_url = trim($_POST['imagen_url'] ?? '');
    $archivo_url = trim($_POST['archivo_pdf_url'] ?? '');
    $titulo = trim($_POST['titulo'] ?? '');
    $activo = isset($_POST['activo']) ? 1 : 0;
    $mode = $_POST['mode'] ?? 'create';
    
    // Validaciones básicas
    if (empty($materia_id) || empty($metodo_aprendizaje_id) || empty($contenido) || empty($tipo)) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'Todos los campos marcados con * son obligatorios.'
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    
    // Obtener información del método de aprendizaje seleccionado
    $metodo_info = peticionSQL(
        "SELECT nombre FROM metodos_aprendizaje WHERE id = ?", 
        [$metodo_aprendizaje_id], 
        true
    );
    
    if (isset($metodo_info['error']) || empty($metodo_info)) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'Error al obtener información del método de aprendizaje.'
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    
    $nombre_metodo = strtolower($metodo_info[0]['nombre']);
    
    // Validar tipo de contenido según el método de aprendizaje
    if (isset($restriccionesMetodos[$nombre_metodo]) && !in_array($tipo, $restriccionesMetodos[$nombre_metodo])) {
        $tipos_permitidos = implode(', ', $restriccionesMetodos[$nombre_metodo]);
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => "Para el método de aprendizaje '{$nombre_metodo}' solo se permiten los siguientes tipos: {$tipos_permitidos}"
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    
    // Validaciones específicas por tipo de contenido
    switch ($tipo) {
        case 'imagen':
            // Validar que se proporcione una imagen
            if (empty($imagen_url) && (!isset($_FILES['imagen_archivo']) || empty($_FILES['imagen_archivo']['name']))) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'danger',
                    'texto' => 'Para contenido de tipo imagen debe proporcionar una URL o subir un archivo de imagen.'
                ];
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
            break;
            
        case 'audio':
            // Validar que se proporcione un archivo de audio o enlace
            if (empty($archivo_url) && (!isset($_FILES['archivo_pdf']) || empty($_FILES['archivo_pdf']['name']))) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'danger',
                    'texto' => 'Para contenido de tipo audio debe proporcionar una URL o subir un archivo de audio.'
                ];
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
            break;
            
        case 'video':
        case 'documento':
        case 'interactivo':
            // Validar que se proporcione un enlace o archivo
            if (empty($archivo_url) && (!isset($_FILES['archivo_pdf']) || empty($_FILES['archivo_pdf']['name']))) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'danger',
                    'texto' => "Para contenido de tipo {$tipo} debe proporcionar una URL o subir un archivo."
                ];
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
            break;
            
        case 'enlace':
            // Validar que se proporcione un enlace
            if (empty($archivo_url)) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'danger',
                    'texto' => 'Para contenido de tipo enlace debe proporcionar una URL.'
                ];
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
            break;
    }
    
    // Manejar subida de imagen
    $imagen_final = $imagen_url;
    
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
            $imagen_final = BASE_URL . 'contenidos/imagenes/' . $new_imagen_name;
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Error al guardar la imagen en el servidor.'
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
    
    // Manejar subida de archivo (audio, video, documento, etc.)
    $archivo_final = $archivo_url;
    
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
        
        // Validar tipo de archivo según el tipo de contenido
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = [];
        
        switch ($tipo) {
            case 'audio':
                $allowed_extensions = ['mp3', 'wav', 'ogg', 'm4a'];
                break;
            case 'video':
                $allowed_extensions = ['mp4', 'avi', 'mov', 'wmv', 'mkv'];
                break;
            case 'documento':
                $allowed_extensions = ['pdf', 'doc', 'docx', 'txt', 'ppt', 'pptx'];
                break;
            case 'interactivo':
                $allowed_extensions = ['zip', 'rar', 'html', 'htm'];
                break;
            default:
                $allowed_extensions = ['pdf']; // Por defecto PDF
        }
        
        if (!in_array($file_ext, $allowed_extensions)) {
            $extensions_str = implode(', ', $allowed_extensions);
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => "Para contenido de tipo {$tipo} solo se permiten archivos: {$extensions_str}"
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        
        // Validar tamaño
        if ($file_size > $max_file_size_archivo) {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'El archivo excede el tamaño máximo permitido (10MB).'
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        
        // Generar nombre único
        $new_file_name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file_name);
        $file_destination = $upload_dir_archivos . $new_file_name;
        
        if (move_uploaded_file($file_tmp, $file_destination)) {
            $archivo_final = BASE_URL . 'contenidos/archivos/' . $new_file_name;
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Error al guardar el archivo en el servidor.'
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
    
    // Preparar datos para la base de datos
    $datos_contenido = [
        'materia_id' => $materia_id,
        'metodo_aprendizaje_id' => $metodo_aprendizaje_id,
        'contenido' => $contenido,
        'recursos' => $archivo_final, // Aquí guardamos el archivo o enlace
        'activo' => $activo,
        'imagen' => $imagen_final,
        'titulo' => $titulo,
    ];
    
    try {
        // Definir $accion al inicio del bloque try para evitar el warning
        $accion = ($mode === 'edit' && !empty($id)) ? 'actualizar' : 'crear';
        
        if ($mode === 'edit' && !empty($id)) {
            
            
            $resultado = actualizarRegistro('materia_metodo_aprendizaje', $id, $datos_contenido);
        } else {            
            $resultado = insertarRegistro('materia_metodo_aprendizaje', $datos_contenido);
        }
        
        if (isset($resultado['error'])) {
            throw new Exception($resultado['error']);
        }
        
        // Usar el participio correcto para el mensaje de éxito
        $accion_mensaje = ($accion === 'actualizar') ? 'actualizado' : 'creado';
        
        $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'texto' => 'Contenido ' . $accion_mensaje . ' correctamente.'
        ];
        
    } catch (Exception $e) {
        // Usar el infinitivo para el mensaje de error
        $accion_mensaje = ($accion === 'actualizar') ? 'actualizar' : 'crear';
        
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'Error al ' . $accion_mensaje . ' el contenido: ' . $e->getMessage()
        ];
    }
    
    header('Location: ' . BASE_URL . 'dashboard.php?seccion=aprendizaje');
    exit;
} else {
    // Si no es POST, redirigir
    header('Location: ' . BASE_URL . 'dashboard.php');
    exit;
}
ob_end_flush();