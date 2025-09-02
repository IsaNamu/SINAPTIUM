<?php
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
}

function renderHead($title = 'Sinaptium') {
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="<?php echo BASE_URL; ?>css/estilos.css">
    <link rel="<?php echo BASE_URL; ?>css/login.css">

    <link href="<?php echo BASE_URL; ?>estilos_bo/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="<?php echo BASE_URL; ?>logo/cerebro.svg" type="image/x-icon">
    <?php
}
?>