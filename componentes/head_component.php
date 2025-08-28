<?php
function renderHead($title = 'Sinaptium', $pather = TRUE) {
    ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo htmlspecialchars($title); ?></title>
        <link href="../estilos_bo/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/estilos.css">
        if ($pather) {
            echo '<link rel="stylesheet" href="./css/estilos.css">';
        } else {
            echo '<link rel="stylesheet" href="../css/estilos.css">';
        }
        <link rel="stylesheet" href="../css/login.css">
        <link rel="icon" href="../logo/cerebrso.svg" type="image/x-icon">
    </head>
    <?php
}
?>