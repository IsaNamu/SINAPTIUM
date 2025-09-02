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

// Verificar que es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['mensaje'] = [
        'tipo' => 'danger',
        'texto' => 'Acceso no permitido'
    ];
    header('Location: usuarios.php');
    exit;
}

// Determinar el modo (crear o editar)
$mode = $_POST['mode'] ?? '';

if ($mode === 'edit') {
    // MODO EDICIÓN
    $id = intval($_POST['id']);
    $usuario = trim($_POST['usuario']);
    $correo = trim($_POST['correo']);
    $rol_id = intval($_POST['rol_id']);
    $activo = isset($_POST['activo']) ? intval($_POST['activo']) : 1;

    // Validaciones
    if (empty($usuario) || empty($correo) || $rol_id <= 0) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'Todos los campos obligatorios deben ser completados'
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'El formato del correo no es válido'
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Verificar si el usuario o correo ya existen (excluyendo el usuario actual)
    $existeUsuario = buscarRegistros('usuario', ['usuario' => $usuario]);
    $existeCorreo = buscarRegistros('usuario', ['correo' => $correo]);
    
    if (is_array($existeUsuario) && !isset($existeUsuario['error'])) {
        foreach ($existeUsuario as $user) {
            if ($user['id'] != $id) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'danger',
                    'texto' => 'El nombre de usuario ya está en uso'
                ];
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
    }
    
    if (is_array($existeCorreo) && !isset($existeCorreo['error'])) {
        foreach ($existeCorreo as $user) {
            if ($user['id'] != $id) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'danger',
                    'texto' => 'El correo electrónico ya está en uso'
                ];
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
    }

    // Preparar datos para actualización
    $datosActualizar = [
        'usuario' => $usuario,
        'correo' => $correo,
        'rol_id' => $rol_id,
        'estado' => ($activo === 1) ? "Activo" : "Inactivo"
    ];
    

    // Si se proporcionó una nueva contraseña, agregarla
    if (!empty($_POST['password'])) {
        if (strlen($_POST['password']) < 1) {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'La contraseña debe tener al menos 1 caracter'
            ];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        $datosActualizar['passwd'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
    }

    // Actualizar el registro
    $resultado = actualizarRegistro('usuario', $id, $datosActualizar);

    if (isset($resultado['error'])) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => $resultado['error']
        ];
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'texto' => $usuario . ' actualizado correctamente'
        ];
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;

} elseif ($mode === 'create') {
    // MODO CREACIÓN
    $usuario = trim($_POST['usuario']);
    $correo = trim($_POST['correo']);
    $password = $_POST['password'];
    $rol_id = intval($_POST['rol_id']);

    // Validaciones básicas
    if (empty($usuario) || empty($correo) || empty($password) || $rol_id <= 0) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'Todos los campos son obligatorios'
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'El formato del correo no es válido'
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    if (strlen($password) < 1) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'La contraseña debe tener al menos 1 caracter'
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Verificar si el usuario o correo ya existen
    $existeUsuario = buscarRegistros('usuario', ['usuario' => $usuario]);
    $existeCorreo = buscarRegistros('usuario', ['correo' => $correo]);
    
    if (is_array($existeUsuario) && !isset($existeUsuario['error']) && count($existeUsuario) > 0) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'El nombre de usuario ya está en uso'
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    
    if (is_array($existeCorreo) && !isset($existeCorreo['error']) && count($existeCorreo) > 0) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'El correo electrónico ya está en uso'
        ];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Hash de la contraseña
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Preparar datos para inserción
    $datosUsuario = [
        'usuario' => $usuario,
        'correo' => $correo,
        'passwd' => $passwordHash,
        'rol_id' => $rol_id,
        'estado' => 1, // Por defecto activo
        'fecha_creacion' => date('Y-m-d H:i:s')
    ];

    // Insertar usuario
    $resultado = insertarRegistro('usuario', $datosUsuario, ['usuario', 'correo']);

    if (isset($resultado['error'])) {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => $resultado['error']
        ];
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'texto' => 'Usuario creado exitosamente'
        ];
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
    
} else {
    // Modo no válido
    $_SESSION['mensaje'] = [
        'tipo' => 'danger',
        'texto' => 'Acción no válida'
    ];
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
?>