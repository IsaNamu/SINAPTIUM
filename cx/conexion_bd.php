<?php

// Obtener variables de entorno con valores por defecto
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_password = getenv('DB_PASSWORD') ?: '';
$db_name = getenv('DB_NAME') ?: 'sinaptium';
$db_port = getenv('DB_PORT') ?: '3306';

// Crear conexión
$conexion = new mysqli($db_host, $db_user, $db_password, $db_name, $db_port);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");

// Opcional: para debugging (quitar en producción)
error_log("Conectado a BD: " . $db_host . ":" . $db_port . " - " . $db_name);

?>