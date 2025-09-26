<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';
include_once HOME_PATH . 'cx/peticiones.php';

// Obtener los contenidos para el método kinestésico de la materia Sociales
$query = "SELECT mma.*, 
                 m.nombre as materia_nombre,
                 ma.nombre as metodo_aprendizaje_nombre,
                 ma.descripcion as metodo_descripcion,
                 (SELECT COUNT(*) 
                  FROM materia_metodo_aprendizaje mma2 
                  WHERE mma2.materia_id = mma.materia_id 
                  AND mma2.metodo_aprendizaje_id = mma.metodo_aprendizaje_id 
                  AND mma2.activo = TRUE) as total_contenidos
          FROM materia_metodo_aprendizaje mma 
          INNER JOIN materias m ON mma.materia_id = m.id 
          INNER JOIN metodos_aprendizaje ma ON mma.metodo_aprendizaje_id = ma.id 
          WHERE mma.activo = TRUE 
          AND m.nombre LIKE '%Social%' 
          AND ma.nombre LIKE '%Kinestésico%'
          ORDER BY m.nombre, ma.nombre, mma.fecha_creacion DESC";

$contenidos = peticionSQL($query, [], true);

if (isset($contenidos['error'])) {
    $contenidos = [];
}

include_once HOME_PATH . 'componentes/head_component.php';
?>
<!doctype html>
<html lang="es">
<head>
    <?php renderHead('Sinaptium - Sociales (Kinestésico)'); ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/estilos.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/sociales.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/ingles.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/biblioteca.css" >
</head>
<style>
    .kinestesico-color {
    color: #FF6B35; /* Color naranja para kinestésico */
}

.kinesthetic-card {
    background: rgba(255, 107, 53, 0.1);
    border: 1px solid #FF6B35;
    border-radius: 15px;
    padding: 20px;
    height: 100%;
    transition: transform 0.3s ease;
}

.kinesthetic-card:hover {
    transform: translateY(-5px);
}

.badge-tipo {
    background: #FF6B35;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
    margin-bottom: 10px;
}
</style>
<body>    
    <div class="neuronal-background"></div>
    <?php include HOME_PATH . 'componentes/navbar.php'; ?>

    <header class="hero text-center text-white py-5">
        <div class="container" data-aos="fade-up">
            <h1 class="kinestesico-color">Sociales: Recursos para Aprendices Kinestésicos</h1>
            <p class="lead">Si aprendes haciendo y explorando, estas actividades te conectarán con el mundo social.</p>
            <a href="sociales.php" class="btn btn-outline-light mt-3">Volver al Test de Sociales</a>
        </div>
    </header>

    <main class="container my-5">
        <!-- Sección de contenidos dinámicos desde la base de datos -->
        <div class="content-section">
            <h2 class="text-center mb-4 kinestesico-color">Contenidos Disponibles</h2>
            
            <?php if (empty($contenidos)): ?>
                <div class="text-center">
                    <p>No hay contenidos disponibles para Sociales - Kinestésico en este momento.</p>
                    <a href="<?php echo BASE_URL; ?>dashboard.php?seccion=aprendizaje" class="btn btn-primary">
                        Agregar Contenido
                    </a>
                </div>
            <?php else: ?>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <?php foreach ($contenidos as $index => $contenido): 
                        // Determinar el tipo de contenido y el icono correspondiente
                        $tipo = '';
                        $icono = '';
                        $clase_card = 'kinesthetic-card';
                        $delay = ($index + 1) * 100;
                        
                        // Analizar el contenido para determinar el tipo (específico para kinestésico)
                        if (strpos(strtolower($contenido['contenido']), 'museo') !== false || 
                            strpos(strtolower($contenido['contenido']), 'visita') !== false ||
                            strpos(strtolower($contenido['contenido']), 'excursión') !== false) {
                            $tipo = 'Visita';
                            $icono = 'location';
                        } elseif (strpos(strtolower($contenido['contenido']), 'juego') !== false || 
                                 strpos(strtolower($contenido['contenido']), 'mesa') !== false ||
                                 strpos(strtolower($contenido['contenido']), 'rol') !== false) {
                            $tipo = 'Juego';
                            $icono = 'game';
                        } elseif (strpos(strtolower($contenido['contenido']), 'maqueta') !== false || 
                                 strpos(strtolower($contenido['contenido']), 'diorama') !== false ||
                                 strpos(strtolower($contenido['contenido']), 'construcción') !== false) {
                            $tipo = 'Construcción';
                            $icono = 'build';
                        } elseif (strpos(strtolower($contenido['contenido']), 'campo') !== false || 
                                 strpos(strtolower($contenido['contenido']), 'observación') !== false ||
                                 strpos(strtolower($contenido['contenido']), 'práctica') !== false) {
                            $tipo = 'Campo';
                            $icono = 'observation';
                        } elseif (strpos(strtolower($contenido['contenido']), 'simulación') !== false || 
                                 strpos(strtolower($contenido['contenido']), 'interactivo') !== false) {
                            $tipo = 'Simulación';
                            $icono = 'simulation';
                            $clase_card = 'kinesthetic-card game-card';
                        } else {
                            $tipo = 'Actividad';
                            $icono = 'activity';
                        }
                        
                        // Usar la imagen del contenido o una por defecto
                        $imagen = !empty($contenido['imagen']) ? $contenido['imagen'] : 'https://placehold.co/600x400?text=Sin+Imagen';
                    ?>
                        <div class="col" data-aos="zoom-in" data-aos-delay="<?php echo $delay; ?>">
                            <div class="<?php echo $clase_card; ?>">
                                <!-- Mostrar la imagen del contenido -->
                                <div class="card-image-container">
                                    <img src="<?php echo htmlspecialchars($imagen); ?>" 
                                         alt="<?php echo htmlspecialchars($contenido['contenido']); ?>" 
                                         class="card-image">
                                </div>
                                
                                <div class="card-body text-center">
                                    <span class="badge badge-tipo"><?php echo $tipo; ?></span>
                                    <h4 class="card-title"><?php echo htmlspecialchars($contenido['contenido']); ?></h4>
                                    
                                    <?php if (!empty($contenido['recursos'])): ?>
                                        <div class="link-list">
                                            <?php 
                                            // Si hay múltiples recursos separados por |, mostrarlos como lista
                                            $recursos = explode('|', $contenido['recursos']);
                                            foreach ($recursos as $recurso):
                                                if (!empty(trim($recurso))):
                                            ?>
                                                <a href="<?php echo htmlspecialchars(trim($recurso)); ?>" 
                                                   target="_blank" 
                                                   class="recurso-link">
                                                    <?php echo htmlspecialchars(trim($recurso)); ?>
                                                </a>
                                            <?php 
                                                endif;
                                            endforeach; 
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="card-meta">
                                        <small class="text-muted">
                                            Creado: <?php echo date('d/m/Y', strtotime($contenido['fecha_creacion'])); ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="text-center py-4 mt-5">
        <p class="text-white-50">© 2025 Sinaptium. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
        });
    </script>
</body>
</html>