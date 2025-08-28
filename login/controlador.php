<?php
// Iniciar sesión al principio del script
session_start();

if (empty($_POST["usuario"]) || empty($_POST["password"])) {
    echo '<div class="alert alert-danger">LOS CAMPOS ESTÁN VACÍOS</div>';
} else {
    $usuario = trim($_POST["usuario"]);
    $clave_ingresada = $_POST["password"];
    
    include ("../cx/conexion_bd.php");
    
    // Consulta para obtener usuario, rol y permisos
    $stmt = $conexion->prepare("SELECT 
                u.*, 
                r.nombre as rol_nombre, 
                r.descripcion as rol_descripcion,
                GROUP_CONCAT(p.nombre SEPARATOR ',') as permisos
            FROM usuario u 
            INNER JOIN roles r ON u.rol_id = r.id 
            LEFT JOIN roles_x_permiso rp ON r.id = rp.rol_id
            LEFT JOIN permisos p ON rp.permiso_id = p.id
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
            $_SESSION['permisos'] = explode(',', $datos->permisos); // Convertir a array
            $_SESSION['fecha_creacion'] = $datos->fecha_creacion;
            $_SESSION['logged_in'] = true;
            $_SESSION['last_activity'] = time(); // Para control de tiempo de sesión
            
            // Redirigir al dashboard o página principal
            header("location:../index.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">CONTRASEÑA INCORRECTA</div>';
        }
    } else {
        echo '<div class="alert alert-danger">USUARIO NO ENCONTRADO</div>';
    }
    
    $stmt->close();
    $conexion->close();
}
?>