<?php
session_start();
// controlador_registro.php
if (empty($_POST["usuario"]) OR empty($_POST["correo"]) OR empty($_POST["password"])) {
    $_SESSION['mensaje'] = '<div class="alert alert-danger">TODOS LOS CAMPOS SON OBLIGATORIOS</div>';
    header("location:./register.php");
    exit;
} else {
    include ("../cx/conexion_bd.php");
    
    // Sanitizar y obtener valores
    $usuario = $conexion->real_escape_string($_POST["usuario"]);
    $correo = $conexion->real_escape_string($_POST["correo"]);
    $clave = $_POST["password"];
    
    // Validar formato de correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">EL FORMATO DEL CORREO NO ES VÁLIDO</div>';
        header("location:./register.php");
        exit;
    }
    
    // Verificar si el usuario ya existe
    $sql_verificar = $conexion->query("SELECT * FROM usuario WHERE usuario='$usuario' OR correo='$correo'");
    if ($sql_verificar->num_rows > 0) {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">EL USUARIO O CORREO YA EXISTE</div>';
        header("location:./register.php");
        exit;
    } else {
        // Asignar rol por defecto
        $rol = (isset($_POST["rol"])) ? $conexion->real_escape_string($_POST["rol"]) : 'estudiante';
        
        // Obtener ID del rol
        $resultado_rol = $conexion->query("SELECT id FROM roles WHERE nombre='$rol'");
        
        if ($resultado_rol && $resultado_rol->num_rows > 0) {
            // El rol existe, obtener su ID
            $id_rol = $resultado_rol->fetch_object()->id;
        } else {
            // El rol no existe, crearlo con permisos de lectura
            
            // 1. Crear el nuevo rol
            $conexion->query("INSERT INTO roles (nombre, descripcion) VALUES ('$rol', 'Rol creado automáticamente para $rol')");
            $id_rol = $conexion->insert_id;
            
            // 2. Verificar si existen los permisos básicos, si no, crearlos
            $permisos_base = array(
                'lectura' => 'Permiso para leer contenido',
                'escritura' => 'Permiso para crear y modificar contenido',
                'eliminacion' => 'Permiso para eliminar contenido',
                'administracion' => 'Permiso de administración completa'
            );
            
            foreach ($permisos_base as $nombre_permiso => $descripcion) {
                // Verificar si el permiso existe
                $resultado_permiso = $conexion->query("SELECT id FROM permisos WHERE nombre='$nombre_permiso'");
                
                if ($resultado_permiso && $resultado_permiso->num_rows == 0) {
                    // El permiso no existe, crearlo
                    $conexion->query("INSERT INTO permisos (nombre, descripcion) VALUES ('$nombre_permiso', '$descripcion')");
                }
            }
            
            // 3. Asignar permiso de lectura al nuevo rol
            // Obtenemos el ID del permiso de lectura
            $resultado_permiso_lectura = $conexion->query("SELECT id FROM permisos WHERE nombre='lectura'");
            
            if ($resultado_permiso_lectura && $resultado_permiso_lectura->num_rows > 0) {
                $id_permiso_lectura = $resultado_permiso_lectura->fetch_object()->id;
                
                // Asignar el permiso al rol
                $conexion->query("INSERT INTO roles_x_permiso (permiso_id, rol_id) VALUES ($id_permiso_lectura, $id_rol)");
                
                $_SESSION['mensaje'] = '<div class="alert alert-info">NUEVO ROL CREADO AUTOMÁTICAMENTE CON PERMISOS DE LECTURA</div>';
            } else {
                $_SESSION['mensaje'] = '<div class="alert alert-warning">SE CREÓ EL ROL PERO NO SE PUDO ASIGNAR EL PERMISO DE LECTURA</div>';
            }
        }
        
        // Hash de la contraseña
        $clave_hash = password_hash($clave, PASSWORD_BCRYPT);
        
        // Insertar nuevo usuario
        $stmt = $conexion->prepare("INSERT INTO usuario (usuario, correo, passwd, rol_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $usuario, $correo, $clave_hash, $id_rol);
        
        if ($stmt->execute()) {
           $_SESSION['mensaje'] = '<div class="alert alert-success">USUARIO REGISTRADO EXITOSAMENTE</div>'; 
        } else {
           $_SESSION['mensaje'] = '<div class="alert alert-danger">ERROR AL REGISTRAR USUARIO: ' . $conexion->error . '</div>';
        }
        
        $stmt->close();
    }
    
    $conexion->close();
    header("location:./register.php");
    exit;
}
?>