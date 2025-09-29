<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';
include_once HOME_PATH . 'cx/peticiones.php';

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensaje'] = [
        'tipo' => 'warning',
        'texto' => 'Debes iniciar sesión para acceder a los recursos personalizados de Ciencias Naturales.'
    ];
    header('Location: ' . BASE_URL . 'ciencias_naturales');
    exit();
}

$estiloAprendizaje = isset($_SESSION['aprendizaje']) ? strtolower($_SESSION['aprendizaje']) : '';
if ($estiloAprendizaje !== 'kinestésico') {
    $_SESSION['mensaje'] = [
        'tipo' => 'info',
        'texto' => 'Tu estilo de aprendizaje detectado es ' . ucfirst($estiloAprendizaje) . '. Estos recursos están optimizados para el estilo auditivo.'
    ];
    header('Location: ' . BASE_URL . 'ciencias_naturales');
    exit();
}

// Obtener los contenidos para el método kinestésico de la materia Ciencias Naturales
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
    <?php renderHead('Sinaptium - Ciencias Naturales (Kinestésico)'); ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/estilos.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/ciencias_naturales.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/ingles.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/biblioteca.css" >
    <style>
        .book-cover img {
            opacity: 1;
        }
        
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

        .bg-kinestesico { background-color: #FF6B35; }
        .bg-laboratorio { background-color: #28a745; }
        .bg-experimento { background-color: #dc3545; }
        .bg-construccion { background-color: #fd7e14; }
        .bg-campo { background-color: #20c997; }
        .bg-simulacion { background-color: #6f42c1; }
        .bg-actividad { background-color: #6c757d; }

        .activity-overlay {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 107, 53, 0.9);
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .book-cover {
            position: relative;
        }

        .at-link_secondary.kinestesico {
            background: #FF6B35;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .at-link_secondary.kinestesico:hover {
            background: #e55a2b;
            transform: translateY(-2px);
        }

        .icon-laboratorio::before { content: '🧪'; }
        .icon-experimento::before { content: '🔬'; }
        .icon-construccion::before { content: '🔨'; }
        .icon-campo::before { content: '🌿'; }
        .icon-simulacion::before { content: '🖥️'; }
        .icon-actividad::before { content: '🏃'; }
    </style>
</head>
<body>    
    <div class="neuronal-background"></div>
    <?php include HOME_PATH . 'componentes/navbar.php'; ?>

    <header class="hero text-center text-white py-5">
        <div class="container" data-aos="fade-up">
            <h1 class="kinestesico-color">Ciencias Naturales: Recursos para Aprendices Kinestésicos</h1>
            <p class="lead">Si aprendes haciendo y experimentando, estas actividades te conectarán con la biología, química, física y ecología.</p>
            <a href="ciencias_naturales" class="btn btn-outline-light mt-3">Volver al Test de Ciencias Naturales</a>
        </div>
    </header>

    <section class="section-padding">
        <div class="container">
            <div class="content-card" data-aos="fade-up">
                <h2 class="text-center mb-4 kinestesico-color">Explora Nuestros Contenidos Interactivos</h2>
                
                <div class="search-container">
                    <input type="text" id="searchBooks" placeholder="Buscar contenidos por título..." class="search-input">
                </div>

                <div class="book-grid" id="bookGrid">
                    <?php if (empty($contenidos)): ?>
                        <div class="col-12 text-center">
                            <p>No hay contenidos disponibles en este momento.</p>
                            <a href="<?php echo BASE_URL; ?>dashboard.php?seccion=aprendizaje" class="btn btn-primary">
                                Agregar Contenido
                            </a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($contenidos as $index => $contenido): 
                            // Determinar el tipo de contenido y la clase del badge
                            $tipo = '';
                            $badgeClass = 'bg-secondary';
                            $esInteractivo = false;
                            $icono = 'icon-actividad';
                            
                            // Analizar el contenido para determinar el tipo (específico para ciencias naturales kinestésico)
                            if (strpos(strtolower($contenido['contenido']), 'laboratorio') !== false || 
                                strpos(strtolower($contenido['contenido']), 'experimento') !== false ||
                                strpos(strtolower($contenido['recursos']), 'phet') !== false ||
                                strpos(strtolower($contenido['recursos']), 'labster') !== false) {
                                $tipo = 'Laboratorio';
                                $badgeClass = 'bg-laboratorio';
                                $icono = 'icon-laboratorio';
                                $esInteractivo = true;
                            } elseif (strpos(strtolower($contenido['contenido']), 'juego') !== false || 
                                     strpos(strtolower($contenido['contenido']), 'simulación') !== false ||
                                     strpos(strtolower($contenido['contenido']), 'interactivo') !== false) {
                                $tipo = 'Simulación';
                                $badgeClass = 'bg-simulacion';
                                $icono = 'icon-simulacion';
                                $esInteractivo = true;
                            } elseif (strpos(strtolower($contenido['contenido']), 'maqueta') !== false || 
                                     strpos(strtolower($contenido['contenido']), 'diorama') !== false ||
                                     strpos(strtolower($contenido['contenido']), 'construcción') !== false ||
                                     strpos(strtolower($contenido['contenido']), 'proyecto') !== false) {
                                $tipo = 'Construcción';
                                $badgeClass = 'bg-construccion';
                                $icono = 'icon-construccion';
                                $esInteractivo = true;
                            } elseif (strpos(strtolower($contenido['contenido']), 'campo') !== false || 
                                     strpos(strtolower($contenido['contenido']), 'observación') !== false ||
                                     strpos(strtolower($contenido['contenido']), 'naturaleza') !== false ||
                                     strpos(strtolower($contenido['contenido']), 'excursión') !== false) {
                                $tipo = 'Campo';
                                $badgeClass = 'bg-campo';
                                $icono = 'icon-campo';
                                $esInteractivo = true;
                            } elseif (strpos(strtolower($contenido['contenido']), 'demostración') !== false || 
                                     strpos(strtolower($contenido['contenido']), 'práctica') !== false ||
                                     strpos(strtolower($contenido['contenido']), 'actividad') !== false) {
                                $tipo = 'Experimento';
                                $badgeClass = 'bg-experimento';
                                $icono = 'icon-experimento';
                                $esInteractivo = true;
                            } else {
                                $tipo = 'Actividad';
                                $badgeClass = 'bg-actividad';
                                $esInteractivo = true;
                            }
                            
                            // Usar la imagen del contenido o una por defecto
                            $imagen = !empty($contenido['imagen']) ? $contenido['imagen'] : 'https://placehold.co/600x400/FF6B35/white?text=Ciencias+Kinestésico';
                        ?>
                            <div class="book-card" data-category="<?php echo strtolower($tipo); ?>">
                                <div class="book-cover">
                                    <img src="<?php echo htmlspecialchars($imagen); ?>" 
                                         alt="<?php echo htmlspecialchars($contenido['contenido']); ?>" 
                                         class="img-fluid">
                                    <?php if ($esInteractivo): ?>
                                        <div class="activity-overlay">
                                            <i class="<?php echo $icono; ?>"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="book-info">
                                    <h5>
                                        <?php if (!empty($contenido['recursos'])): 
                                            $primerRecurso = explode('|', $contenido['recursos'])[0];
                                        ?>
                                            <a href="<?php echo htmlspecialchars(trim($primerRecurso)); ?>" target="_blank">
                                                <?php echo htmlspecialchars($contenido['contenido']); ?>
                                            </a>
                                        <?php else: ?>
                                            <?php echo htmlspecialchars($contenido['contenido']); ?>
                                        <?php endif; ?>
                                    </h5>
                                    
                                    <p class="book-author">
                                        <?php if (!empty($contenido['titulo'])): ?>
                                            <?php echo htmlspecialchars($contenido['titulo']); ?>
                                        <?php else: ?>
                                            <span class="text-muted">Sin descripción adicional</span>
                                        <?php endif; ?>
                                    </p>
                                    
                                    <span class="badge book-badge <?php echo $badgeClass; ?>">
                                        <?php echo $tipo; ?>
                                    </span>
                                    
                                    <!-- Botón de acción para actividades kinestésicas -->
                                    <?php if ($esInteractivo && !empty($contenido['recursos'])): ?>
                                        <div class="button-action mt-2">
                                            <button class="at-link_secondary kinestesico activity-btn" 
                                                    data-activity-url="<?php echo htmlspecialchars(trim(explode('|', $contenido['recursos'])[0])); ?>">
                                                Experimentar <i class="<?php echo $icono; ?>"></i>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($contenido['recursos'])): ?>
                                        <div class="link-list mt-2">
                                            <?php 
                                            $recursos = explode('|', $contenido['recursos']);
                                            foreach ($recursos as $recurso):
                                                if (!empty(trim($recurso))):
                                            ?>
                                                <a href="<?php echo htmlspecialchars(trim($recurso)); ?>" 
                                                   target="_blank" 
                                                   class="recurso-link small">
                                                    <?php 
                                                    $dominio = parse_url(trim($recurso), PHP_URL_HOST);
                                                    echo htmlspecialchars($dominio ?: 'Recurso');
                                                    ?>
                                                </a>
                                            <?php 
                                                endif;
                                            endforeach; 
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="card-meta mt-2">
                                        <small class="text-muted">
                                            Creado: <?php echo date('d/m/Y', strtotime($contenido['fecha_creacion'])); ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>    
        </div>
    </section>

    <!-- Sección de recursos predeterminados (si no hay contenidos en BD) -->
    <?php if (empty($contenidos)): ?>
    <section class="container my-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div class="col" data-aos="zoom-in" data-aos-delay="100">
                <div class="book-card">
                    <div class="book-cover">
                        <img src="https://placehold.co/600x400/FF6B35/white?text=Laboratorios" alt="Laboratorios" class="img-fluid">
                        <div class="activity-overlay">
                            <i class="icon-laboratorio"></i>
                        </div>
                    </div>
                    <div class="book-info">
                        <h5>Laboratorios Virtuales</h5>
                        <p class="book-author">Realiza experimentos de física, química y biología en entornos digitales seguros</p>
                        <span class="badge book-badge bg-laboratorio">Laboratorio</span>
                        <div class="button-action mt-2">
                            <button class="at-link_secondary kinestesico activity-btn" data-activity-url="https://phet.colorado.edu/es/">
                                Experimentar <i class="icon-laboratorio"></i>
                            </button>
                        </div>
                        <div class="link-list mt-2">
                            <a href="https://phet.colorado.edu/es/" target="_blank" class="recurso-link small">Simulaciones PhET</a>
                            <a href="https://labster.com/" target="_blank" class="recurso-link small">Laboratorios Labster</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col" data-aos="zoom-in" data-aos-delay="200">
                <div class="book-card">
                    <div class="book-cover">
                        <img src="https://placehold.co/600x400/FF6B35/white?text=Proyectos" alt="Proyectos" class="img-fluid">
                        <div class="activity-overlay">
                            <i class="icon-construccion"></i>
                        </div>
                    </div>
                    <div class="book-info">
                        <h5>Maquetas y Proyectos DIY</h5>
                        <p class="book-author">Construye modelos del sistema solar, células o circuitos eléctricos</p>
                        <span class="badge book-badge bg-construccion">Construcción</span>
                        <div class="button-action mt-2">
                            <button class="at-link_secondary kinestesico activity-btn" data-activity-url="https://science.nasa.gov/science-activation-programs/do-it-yourself-science/">
                                Construir <i class="icon-construccion"></i>
                            </button>
                        </div>
                        <div class="link-list mt-2">
                            <a href="https://science.nasa.gov/science-activation-programs/do-it-yourself-science/" target="_blank" class="recurso-link small">Proyectos NASA</a>
                            <a href="https://www.instructables.com/circuits/" target="_blank" class="recurso-link small">Proyectos Electrónicos</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col" data-aos="zoom-in" data-aos-delay="300">
                <div class="book-card">
                    <div class="book-cover">
                        <img src="https://placehold.co/600x400/FF6B35/white?text=Juegos" alt="Juegos" class="img-fluid">
                        <div class="activity-overlay">
                            <i class="icon-simulacion"></i>
                        </div>
                    </div>
                    <div class="book-info">
                        <h5>Juego: Mundo Sináptico</h5>
                        <p class="book-author">Experiencia interactiva para construir, explorar y simular conceptos científicos</p>
                        <span class="badge book-badge bg-simulacion">Simulación</span>
                        <div class="button-action mt-2">
                            <button class="at-link_secondary kinestesico activity-btn" data-activity-url="MundoSinaptico/game.php">
                                Jugar <i class="icon-simulacion"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

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
        
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchBooks');
            const bookGrid = document.getElementById('bookGrid');
            const bookCards = bookGrid ? bookGrid.querySelectorAll('.book-card') : [];

            if (searchInput && bookGrid) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    
                    bookCards.forEach(function(card) {
                        const title = card.querySelector('h5').textContent.toLowerCase();
                        const author = card.querySelector('.book-author').textContent.toLowerCase();
                        const category = card.getAttribute('data-category');
                        
                        // Buscar en título, autor y categoría
                        const matches = title.includes(searchTerm) || 
                                       author.includes(searchTerm) || 
                                       category.includes(searchTerm);
                        
                        if (matches || searchTerm === '') {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            }

            // Botones de actividad kinestésica
            document.querySelectorAll('.activity-btn').forEach(function(boton) {
                boton.addEventListener('click', function() {
                    const activityUrl = this.getAttribute('data-activity-url');
                    if (activityUrl) {
                        window.open(activityUrl, '_blank');
                    }
                });
            });

            // Precarga de imágenes
            const images = document.querySelectorAll('.book-cover img');
            images.forEach(img => {
                if (img.complete) {
                    img.classList.add('loaded');
                } else {
                    img.addEventListener('load', function() {
                        this.classList.add('loaded');
                    });
                }
            });
        });
    </script>
</body>
</html>