<?php
include_once 'conexion_bd.php'; // Asegúrate de que este es el nombre correcto de tu archivo de conexión

/**
 * Método para listar todos los registros de una tabla
 * @param string $tabla Nombre de la tabla
 * @param int|null $id ID específico a buscar (opcional)
 * @param string $campo_id Nombre del campo ID (por defecto 'id')
 * @return array|false Array con los resultados o false en caso de error
 */
function listarRegistros($tabla, $id = null, $campo_id = 'id') {
    global $conexion;
    
    // Validar que la tabla existe
    if (!validarTabla($tabla)) {
        return ['error' => 'Tabla no válida'];
    }
    
    $sql = "SELECT * FROM $tabla";
    
    // Si se especificó un ID, filtrar por ese ID
    if ($id !== null) {
        $id = $conexion->real_escape_string($id);
        $campo_id = $conexion->real_escape_string($campo_id);
        $sql .= " WHERE $campo_id = $id";
    }
    
    $resultado = $conexion->query($sql);
    
    if (!$resultado) {
        return ['error' => 'Error en la consulta: ' . $conexion->error];
    }
    
    $datos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }
    
    return $datos;
}

/**
 * Método para insertar un nuevo registro
 * @param string $tabla Nombre de la tabla
 * @param array $datos Array asociativo con los datos a insertar (campo => valor)
 * @param array $camposUnicos Campos que deben ser únicos (para validar duplicados)
 * @return array|false Array con el resultado o false en caso de error
 */
function insertarRegistro($tabla, $datos, $camposUnicos = []) {
    global $conexion;
    
    // Validar que la tabla existe
    if (!validarTabla($tabla)) {
        return ['error' => 'Tabla no válida'];
    }
    
    // Validar si ya existe un registro con los mismos valores en campos únicos
    if (!empty($camposUnicos)) {
        $whereConditions = [];
        foreach ($camposUnicos as $campo) {
            if (isset($datos[$campo])) {
                $valor = $conexion->real_escape_string($datos[$campo]);
                $whereConditions[] = "$campo = '$valor'";
            }
        }
        
        if (!empty($whereConditions)) {
            $sqlCheck = "SELECT COUNT(*) as total FROM $tabla WHERE " . implode(' OR ', $whereConditions);
            $resultadoCheck = $conexion->query($sqlCheck);
            
            if ($resultadoCheck && $resultadoCheck->fetch_assoc()['total'] > 0) {
                return ['error' => 'Ya existe un registro con esos valores'];
            }
        }
    }
    
    // Preparar campos y valores para la inserción
    $campos = [];
    $valores = [];
    
    foreach ($datos as $campo => $valor) {
        $campos[] = $conexion->real_escape_string($campo);
        $valores[] = "'" . $conexion->real_escape_string($valor) . "'";
    }
    
    $sql = "INSERT INTO $tabla (" . implode(', ', $campos) . ") VALUES (" . implode(', ', $valores) . ")";
    
    if ($conexion->query($sql)) {
        $idInsertado = $conexion->insert_id;
        return [
            'success' => true,
            'id' => $idInsertado,
            'mensaje' => 'Registro insertado correctamente'
        ];
    } else {
        return ['error' => 'Error al insertar: ' . $conexion->error];
    }
}

/**
 * Método para actualizar un registro
 * @param string $tabla Nombre de la tabla
 * @param int $id ID del registro a actualizar
 * @param array $datos Array asociativo con los datos a actualizar (campo => valor)
 * @param string $campo_id Nombre del campo ID (por defecto 'id')
 * @return array|false Array con el resultado o false en caso de error
 */
function actualizarRegistro($tabla, $id, $datos, $campo_id = 'id') {
    global $conexion;
    
    // Validar que la tabla existe
    if (!validarTabla($tabla)) {
        return ['error' => 'Tabla no válida'];
    }
    
    // Preparar los campos a actualizar
    $actualizaciones = [];
    
    foreach ($datos as $campo => $valor) {
        $campoEscapado = $conexion->real_escape_string($campo);
        $valorEscapado = $conexion->real_escape_string($valor);
        $actualizaciones[] = "$campoEscapado = '$valorEscapado'";
    }
    
    $id = $conexion->real_escape_string($id);
    $campo_id = $conexion->real_escape_string($campo_id);
    
    $sql = "UPDATE $tabla SET " . implode(', ', $actualizaciones) . " WHERE $campo_id = $id";
    
    if ($conexion->query($sql)) {
        if ($conexion->affected_rows > 0) {
            return [
                'success' => true,
                'mensaje' => 'Registro actualizado correctamente',
                'filas_afectadas' => $conexion->affected_rows
            ];
        } else {
            return ['error' => 'No se encontró el registro o los datos son iguales'];
        }
    } else {
        return ['error' => 'Error al actualizar: ' . $conexion->error];
    }
}

/**
 * Método para eliminar un registro
 * @param string $tabla Nombre de la tabla
 * @param int $id ID del registro a eliminar
 * @param string $campo_id Nombre del campo ID (por defecto 'id')
 * @return array|false Array con el resultado o false en caso de error
 */
function eliminarRegistro($tabla, $id, $campo_id = 'id') {
    global $conexion;
    
    // Validar que la tabla existe
    if (!validarTabla($tabla)) {
        return ['error' => 'Tabla no válida'];
    }
    
    $id = $conexion->real_escape_string($id);
    $campo_id = $conexion->real_escape_string($campo_id);
    
    $sql = "DELETE FROM $tabla WHERE $campo_id = $id";
    
    if ($conexion->query($sql)) {
        if ($conexion->affected_rows > 0) {
            return [
                'success' => true,
                'mensaje' => 'Registro eliminado correctamente',
                'filas_afectadas' => $conexion->affected_rows
            ];
        } else {
            return ['error' => 'No se encontró el registro'];
        }
    } else {
        return ['error' => 'Error al eliminar: ' . $conexion->error];
    }
}

/**
 * Función para validar que una tabla existe en la base de datos
 * @param string $tabla Nombre de la tabla a validar
 * @return bool True si la tabla existe, false si no
 */
function validarTabla($tabla) {
    global $conexion;
    
    $tablasPermitidas = ['usuario', 'roles', 'permisos', 'roles_x_permiso', 'categorias', 'biblioteca', 'autores', 'categorias']; // Agrega aquí todas tus tablas
    
    // Validación básica por seguridad
    if (!in_array($tabla, $tablasPermitidas)) {
        return false;
    }
    
    // Validación adicional consultando la base de datos
    $tabla = $conexion->real_escape_string($tabla);
    $resultado = $conexion->query("SHOW TABLES LIKE '$tabla'");
    
    return $resultado && $resultado->num_rows > 0;
}

/**
 * Método para buscar registros con condiciones personalizadas
 * @param string $tabla Nombre de la tabla
 * @param array $condiciones Array asociativo con las condiciones (campo => valor)
 * @param string $operador Operador lógico para las condiciones (AND u OR)
 * @return array|false Array con los resultados o false en caso de error
 */
function buscarRegistros($tabla, $condiciones = [], $operador = 'AND') {
    global $conexion;
    
    // Validar que la tabla existe
    if (!validarTabla($tabla)) {
        return ['error' => 'Tabla no válida'];
    }
    
    $sql = "SELECT * FROM $tabla";
    
    // Si hay condiciones, agregarlas a la consulta
    if (!empty($condiciones)) {
        $whereConditions = [];
        
        foreach ($condiciones as $campo => $valor) {
            $campoEscapado = $conexion->real_escape_string($campo);
            $valorEscapado = $conexion->real_escape_string($valor);
            $whereConditions[] = "$campoEscapado = '$valorEscapado'";
        }
        
        $sql .= " WHERE " . implode(" $operador ", $whereConditions);
    }
    
    $resultado = $conexion->query($sql);
    
    if (!$resultado) {
        return ['error' => 'Error en la consulta: ' . $conexion->error];
    }
    
    $datos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }
    
    return $datos;
}

/** 
 * Metodo para ejecutar consultas SQL personalizadas
 * @param string $sql Consulta SQL a ejecutar
 * @param array $params Parámetros para consultas preparadas (opcional)
 * @param bool $returnResult Si debe retornar resultados para SELECT (true) o solo éxito/error (false)
 * @return array|bool Resultados de la consulta o éxito/error
 */
function peticionSQL($sql, $params = [], $returnResult = true) {
    global $conexion;

    // Si hay parámetros, usar consulta preparada
    if (!empty($params)) {
        $stmt = $conexion->prepare($sql);
        
        if (!$stmt) {
            return ['error' => 'Error al preparar la consulta: ' . $conexion->error];
        }
        
        // Construir tipos de parámetros
        $types = '';
        $bindParams = [];
        
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_double($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
            $bindParams[] = $param;
        }
        
        // Vincular parámetros
        $stmt->bind_param($types, ...$bindParams);
        
        // Ejecutar consulta
        $success = $stmt->execute();
        
        if (!$success) {
            return ['error' => 'Error al ejecutar la consulta: ' . $stmt->error];
        }
        
        // Si es una consulta SELECT y se requieren resultados
        if ($returnResult && stripos(trim($sql), 'SELECT') === 0) {
            $result = $stmt->get_result();
            $datos = [];
            
            while ($fila = $result->fetch_assoc()) {
                $datos[] = $fila;
            }
            
            $stmt->close();
            return $datos;
        }
        
        // Para INSERT, UPDATE, DELETE
        $affectedRows = $stmt->affected_rows;
        $stmt->close();
        
        return $affectedRows > 0;
    } 
    else {
        // Consulta sin parámetros (comportamiento original)
        $resultado = $conexion->query($sql);

        if (!$resultado) {
            return ['error' => 'Error en la consulta: ' . $conexion->error];
        }

        // Si es una consulta SELECT
        if ($returnResult && stripos(trim($sql), 'SELECT') === 0) {
            $datos = [];
            while ($fila = $resultado->fetch_assoc()) {
                $datos[] = $fila;
            }
            return $datos;
        }
        
        // Para INSERT, UPDATE, DELETE
        return $conexion->affected_rows > 0;
    }
}
?>
