<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/Sinaptium/');
}

if (!defined('HOME_PATH')) {
    define('HOME_PATH', $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/');
}

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
}

if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__);
}
?>