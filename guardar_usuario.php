<?php
include_once './cx/peticiones.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y validar datos
    $usuario = trim($_POST['usuario']);
    $correo = trim($_POST['correo']);
    $password = $_POST['password'];
    $rol_id = intval($_POST['rol_id']);
    
    // Validaciones básicas
    if (empty($usuario) || empty($correo) || empty($password) || $rol_id <= 0) {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">Todos los campos son obligatorios</div>';
        header('Location: usuarios_lista.php');
        exit;
    }
    
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">El formato del correo no es válido</div>';
        header('Location: usuarios_lista.php');
        exit;
    }
    
    // Hash de la contraseña
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    
    // Preparar datos para inserción
    $datosUsuario = [
        'usuario' => $usuario,
        'correo' => $correo,
        'passwd' => $passwordHash,
        'rol_id' => $rol_id
    ];
    
    // Insertar usuario
    $resultado = insertarRegistro('usuario', $datosUsuario, ['usuario', 'correo']);
    
    if (isset($resultado['error'])) {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">' . $resultado['error'] . '</div>';
    } else {
        $_SESSION['mensaje'] = '<div class="alert alert-success">Usuario creado exitosamente</div>';
    }
    
    header('Location: usuarios.php');
    exit;
}