<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';
include_once HOME_PATH . 'cx/peticiones.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensaje'] = [
        'tipo' => 'warning',
        'texto' => 'Debes iniciar sesión para acceder a los recursos personalizados de Ciencias Naturales.'
    ];
    header('Location: ' . BASE_URL . 'ciencias_naturales');
    exit();
}

// Verificar si el usuario tiene el estilo de aprendizaje visual
$estiloAprendizaje = isset($_SESSION['aprendizaje']) ? strtolower($_SESSION['aprendizaje']) : '';
if ($estiloAprendizaje !== 'visual') {
    $_SESSION['mensaje'] = [
        'tipo' => 'info',
        'texto' => 'Tu estilo de aprendizaje detectado es ' . ucfirst($estiloAprendizaje) . '. Estos recursos están optimizados para el estilo auditivo.'
    ];
    header('Location: ' . BASE_URL . 'ciencias_naturales');
    exit();
}

// Obtener los contenidos para el método visual de la materia Ciencias Naturales
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
          AND m.nombre LIKE '%Ciencias Naturales%' 
          AND ma.nombre LIKE '%Visual%'
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
    <?php renderHead('Sinaptium - Ciencias Naturales (Visual)'); ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/estilos.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/ciencias_naturales.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/ingles.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/biblioteca.css" >
    <style>
        .visual-color {
            color: #4CAF50; /* Color verde para ciencias naturales visual */
        }

        .visual-card {
            background: rgba(76, 175, 80, 0.1);
            border: 1px solid #4CAF50;
            border-radius: 15px;
            padding: 20px;
            height: 100%;
            transition: transform 0.3s ease;
        }

        .visual-card:hover {
            transform: translateY(-5px);
        }

        .badge-tipo {
            background: #4CAF50;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            margin-bottom: 10px;
        }

        .card-image-container {
            width: 100%;
            height: 200px;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .recurso-link {
            display: block;
            color: #4CAF50;
            text-decoration: none;
            margin: 5px 0;
            word-break: break-all;
        }

        .recurso-link:hover {
            text-decoration: underline;
        }

        .link-list {
            margin: 15px 0;
        }
    </style>
</head>
<body>    
    <div class="neuronal-background"></div>
    <?php include HOME_PATH . 'componentes/navbar.php'; ?>

    <header class="hero text-center text-white py-5">
        <div class="container" data-aos="fade-up">
            <h1 class="visual-color">Ciencias Naturales: Recursos para Aprendices Visuales</h1>
            <p class="lead">Si aprendes mejor viendo, estas herramientas visuales te ayudarán a comprender la biología, química, física y ecología.</p>
            <a href="ciencias_naturales.php" class="btn btn-outline-light mt-3">Volver al Test de Ciencias Naturales</a>
        </div>
    </header>

    <main class="container my-5">
        <!-- Sección de contenidos dinámicos desde la base de datos -->
        <div class="content-section">
            <h2 class="text-center mb-4 visual-color">Contenidos Disponibles</h2>
            
            <?php if (empty($contenidos)): ?>
                <div class="text-center">
                    <p>No hay contenidos disponibles para Ciencias Naturales - Visual en este momento.</p>
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
                        $clase_card = 'visual-card';
                        $delay = ($index + 1) * 100;
                        
                        // Analizar el contenido para determinar el tipo (específico para ciencias naturales visual)
                        if (strpos(strtolower($contenido['contenido']), 'diagrama') !== false || 
                            strpos(strtolower($contenido['contenido']), 'gráfico') !== false ||
                            strpos(strtolower($contenido['recursos']), 'canva') !== false) {
                            $tipo = 'Diagrama';
                            $icono = 'chart';
                        } elseif (strpos(strtolower($contenido['contenido']), 'video') !== false || 
                                 strpos(strtolower($contenido['contenido']), 'documental') !== false ||
                                 strpos(strtolower($contenido['recursos']), 'youtube') !== false) {
                            $tipo = 'Video';
                            $icono = 'video';
                        } elseif (strpos(strtolower($contenido['contenido']), 'simulación') !== false || 
                                 strpos(strtolower($contenido['contenido']), 'interactivo') !== false ||
                                 strpos(strtolower($contenido['recursos']), 'phet') !== false) {
                            $tipo = 'Simulación';
                            $icono = 'science';
                        } elseif (strpos(strtolower($contenido['contenido']), 'juego') !== false || 
                                 strpos(strtolower($contenido['contenido']), 'explorador') !== false) {
                            $tipo = 'Juego';
                            $icono = 'game';
                            $clase_card = 'visual-card game-card';
                        } elseif (strpos(strtolower($contenido['contenido']), 'infografía') !== false || 
                                 strpos(strtolower($contenido['contenido']), 'esquema') !== false) {
                            $tipo = 'Infografía';
                            $icono = 'info';
                        } else {
                            $tipo = 'Recurso Visual';
                            $icono = 'visual';
                        }
                        
                        // Usar la imagen del contenido o una por defecto
                        $imagen = !empty($contenido['imagen']) ? $contenido['imagen'] : 'https://placehold.co/600x400/4CAF50/white?text=Ciencias+Naturales';
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

        <!-- Sección de recursos predeterminados (si no hay contenidos en BD) -->
        <?php if (empty($contenidos)): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-4">
            <div class="col" data-aos="zoom-in" data-aos-delay="100">
                <div class="visual-card">
                    <div class="card-image-container">
                        <img src="https://placehold.co/600x400/4CAF50/white?text=Diagramas" alt="Diagramas" class="card-image">
                    </div>
                    <div class="card-body text-center">
                        <span class="badge badge-tipo">Diagrama</span>
                        <h4 class="card-title">Diagramas y Gráficos Científicos</h4>
                        <p class="card-text">Comprende ciclos biológicos, procesos químicos y estructuras atómicas a través de representaciones gráficas.</p>
                        <div class="link-list">
                            <a href="https://www.canva.com/es_co/graficos/diagramas-de-flujo/" target="_blank" class="recurso-link">Diagramas de Flujo en Canva</a>
                            <a href="https://biointeractive.org/es" target="_blank" class="recurso-link">Recursos Visuales de BioInteractive</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col" data-aos="zoom-in" data-aos-delay="200">
                <div class="visual-card">
                    <div class="card-image-container">
                        <img src="https://placehold.co/600x400/4CAF50/white?text=Videos" alt="Videos" class="card-image">
                    </div>
                    <div class="card-body text-center">
                        <span class="badge badge-tipo">Video</span>
                        <h4 class="card-title">Videos y Demostraciones Científicas</h4>
                        <p class="card-text">Observa experimentos de laboratorio y el mundo natural a través de videos educativos.</p>
                        <div class="link-list">
                            <a href="https://www.youtube.com/user/kurzgesagt" target="_blank" class="recurso-link">Kurzgesagt – In a Nutshell</a>
                            <a href="https://www.youtube.com/user/NatGeo" target="_blank" class="recurso-link">National Geographic</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col" data-aos="zoom-in" data-aos-delay="300">
                <div class="visual-card">
                    <div class="card-image-container">
                        <img src="https://placehold.co/600x400/4CAF50/white?text=Simulaciones" alt="Simulaciones" class="card-image">
                    </div>
                    <div class="card-body text-center">
                        <span class="badge badge-tipo">Simulación</span>
                        <h4 class="card-title">Simulaciones Interactivas</h4>
                        <p class="card-text">Explora modelos 3D de células, ADN y fenómenos físicos mediante simulaciones visuales.</p>
                        <div class="link-list">
                            <a href="https://phet.colorado.edu/es/" target="_blank" class="recurso-link">Simulaciones de PhET</a>
                            <a href="ScienceQuiz/game.php" target="_blank" class="recurso-link">Juego: Science Quest</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </main>

    <?php include HOME_PATH . 'componentes/footer_component.php'; ?>

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