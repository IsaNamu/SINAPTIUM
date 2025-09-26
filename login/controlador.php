<?php
// Iniciar sesión y configurar constantes
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';

if (empty($_POST["usuario"]) || empty($_POST["password"])) {
    $_SESSION['mensaje'] = [
        'tipo' => 'danger',
        'texto' => 'TODOS LOS CAMPOS SON OBLIGATORIOS'
    ];
    header("Location: " . BASE_URL . "login");
    exit;

} else {
    $usuario = trim($_POST["usuario"]);
    $clave_ingresada = $_POST["password"];
    
    include ("../cx/conexion_bd.php");
    
    // Consulta para obtener usuario, rol y permisos
    $stmt = $conexion->prepare("SELECT 
            u.*, 
            r.nombre as rol_nombre, 
            r.descripcion as rol_descripcion,
            ma.nombre as metodo_aprendizaje_nombre,
            ma.descripcion as metodo_aprendizaje_descripcion,
            GROUP_CONCAT(p.nombre SEPARATOR ',') as permisos
        FROM usuario u 
        INNER JOIN roles r ON u.rol_id = r.id 
        LEFT JOIN roles_x_permiso rp ON r.id = rp.rol_id
        LEFT JOIN permisos p ON rp.permiso_id = p.id
        LEFT JOIN metodos_aprendizaje ma ON u.metodo_aprendizaje_id = ma.id
        WHERE u.usuario = ? OR u.correo = ?
        GROUP BY u.id");
    
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        $datos = $resultado->fetch_object();
        
        // Verificar la contraseña hasheada
        if (password_verify($clave_ingresada, $datos->passwd)) {
            // Configurar todas las variables de sesión
            $_SESSION['usuario_id'] = $datos->id;
            $_SESSION['usuario'] = $datos->usuario;
            $_SESSION['correo'] = $datos->correo;
            $_SESSION['rol_id'] = $datos->rol_id;
            $_SESSION['rol_nombre'] = $datos->rol_nombre;
            $_SESSION['rol_descripcion'] = $datos->rol_descripcion;
            $_SESSION['aprendizaje'] = $datos->metodo_aprendizaje_nombre;
            $_SESSION['permisos'] = !empty($datos->permisos) ? explode(',', $datos->permisos) : [];
            $_SESSION['fecha_creacion'] = $datos->fecha_creacion;
            $_SESSION['logged_in'] = true;
            $_SESSION['last_activity'] = time(); // Para control de tiempo de sesión
            
            // Redirigir al dashboard o página principal
            if ($_SESSION['rol_nombre'] === 'Administrador') {
                $_SESSION['mensaje'] = [
                    'tipo' => 'success',
                    'texto' => 'BIENVENIDO ADMINISTRADOR ' . $_SESSION['usuario']
                ];
                header("location:/Sinaptium/dashboard.php");
                exit;
            } else {
                $_SESSION['mensaje'] = [
                    'tipo' => 'success',
                    'texto' => 'BIENVENIDO ' . $_SESSION['usuario']
                ];
                header("location:/Sinaptium/");
                exit;
            }
            header("location:/Sinaptium/dashboard.php");
            exit;
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'CONTRASEÑA INCORRECTA'
            ];
            header("Location: " . BASE_URL . "login");
            exit;
        }
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'USUARIO NO ENCONTRADO'
        ];
        header("Location: " . BASE_URL . "login");
        exit;
    }
    
    $stmt->close();
    $conexion->close();
}
?>