<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ./login/login.php");
    exit;
}

// Verificar inactividad (opcional, 30 minutos de inactividad)
$inactivity_limit = 1800; // 30 minutos en segundos
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactivity_limit)) {
    // Cerrar sesión por inactividad
    session_unset();
    session_destroy();
    header("Location: ./login/login.php?reason=inactivity");
    exit;
}

// Actualizar tiempo de última actividad
$_SESSION['last_activity'] = time();

// Función para verificar permisos
function tiene_permiso($permiso_requerido) {
    return isset($_SESSION['permisos']) && in_array($permiso_requerido, $_SESSION['permisos']);
}
?>