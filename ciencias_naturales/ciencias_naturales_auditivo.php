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

// Verificar si el usuario tiene el estilo de aprendizaje auditivo
$estiloAprendizaje = isset($_SESSION['aprendizaje']) ? strtolower($_SESSION['aprendizaje']) : '';
if ($estiloAprendizaje !== 'auditivo') {
    $_SESSION['mensaje'] = [
        'tipo' => 'info',
        'texto' => 'Tu estilo de aprendizaje detectado es ' . ucfirst($estiloAprendizaje) . '. Estos recursos están optimizados para el estilo auditivo.'
    ];
    header('Location: ' . BASE_URL . 'ciencias_naturales');
    exit();
}

// Obtener los contenidos para el método auditivo de la materia Ciencias Naturales
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
          AND ma.nombre LIKE '%Auditivo%'
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
    <?php renderHead('Sinaptium - Ciencias Naturales (Auditivo)'); ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/estilos.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/ciencias_naturales.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/ingles.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/biblioteca.css" >
    <style>
        .book-cover img {
            opacity: 1;
        }
        
        .auditivo-color {
            color: #2196F3; /* Color azul para auditivo */
        }
        
        .bg-auditivo {
            background: #2196F3;
        }
        
        .audio-overlay {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(33, 150, 243, 0.9);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .audio-play-btn {
            background: #2196F3;
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .audio-play-btn:hover {
            background: #1976D2;
            transform: scale(1.05);
        }
        
        .audio-play-btn.playing {
            background: #FF9800;
        }
    </style>
</head>
<body>    
    <div class="neuronal-background"></div>
    <?php include HOME_PATH . 'componentes/navbar.php'; ?>

    <header class="hero text-center text-white py-5">
        <div class="container" data-aos="fade-up">
            <h1 class="auditivo-color">Ciencias Naturales: Recursos para Aprendices Auditivos</h1>
            <p class="lead">Si aprendes mejor escuchando, estas fuentes de audio te ayudarán a entender la biología, química, física y ecología.</p>
            <a href="ciencias_naturales.php" class="btn btn-outline-light mt-3">Volver al Test de Ciencias Naturales</a>
        </div>
    </header>

    <section class="section-padding">
        <div class="container">
            <div class="content-card" data-aos="fade-up">
                <h2 class="text-center mb-4 auditivo-color">Explora Nuestros Contenidos Auditivos</h2>
                
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
                            $esAudio = false;
                            $urlAudio = '';
                            
                            // Analizar el contenido para determinar el tipo (específico para ciencias naturales auditivo)
                            if (strpos(strtolower($contenido['contenido']), 'podcast') !== false || 
                                strpos(strtolower($contenido['recursos']), 'spotify') !== false ||
                                strpos(strtolower($contenido['recursos']), 'audio') !== false ||
                                strpos(strtolower($contenido['recursos']), '.mp3') !== false ||
                                strpos(strtolower($contenido['recursos']), '.ogg') !== false ||
                                strpos(strtolower($contenido['recursos']), '.wav') !== false ||
                                strpos(strtolower($contenido['recursos']), '.m4a') !== false ||
                                strpos(strtolower($contenido['recursos']), '.aac') !== false ||
                                strpos(strtolower($contenido['recursos']), 'stream') !== false) {
                                $tipo = 'Podcast';
                                $badgeClass = 'bg-auditivo';
                                $esAudio = true;
                                
                                // Extraer la URL de audio del primer recurso
                                if (!empty($contenido['recursos'])) {
                                    $recursos = explode('|', $contenido['recursos']);
                                    $primerRecurso = trim($recursos[0]);
                                    if (filter_var($primerRecurso, FILTER_VALIDATE_URL)) {
                                        $urlAudio = $primerRecurso;
                                    }
                                }
                            } elseif (strpos(strtolower($contenido['contenido']), 'conferencia') !== false || 
                                    strpos(strtolower($contenido['contenido']), 'charla') !== false ||
                                    strpos(strtolower($contenido['recursos']), 'ted') !== false) {
                                $tipo = 'Conferencia';
                                $badgeClass = 'bg-blue';
                                $esAudio = true;
                                
                                if (!empty($contenido['recursos'])) {
                                    $recursos = explode('|', $contenido['recursos']);
                                    $primerRecurso = trim($recursos[0]);
                                    if (filter_var($primerRecurso, FILTER_VALIDATE_URL)) {
                                        $urlAudio = $primerRecurso;
                                    }
                                }
                            } elseif (strpos(strtolower($contenido['contenido']), 'audiolibro') !== false || 
                                    strpos(strtolower($contenido['recursos']), 'audible') !== false) {
                                $tipo = 'Audiolibro';
                                $badgeClass = 'bg-green';
                                $esAudio = true;
                                
                                if (!empty($contenido['recursos'])) {
                                    $recursos = explode('|', $contenido['recursos']);
                                    $primerRecurso = trim($recursos[0]);
                                    if (filter_var($primerRecurso, FILTER_VALIDATE_URL)) {
                                        $urlAudio = $primerRecurso;
                                    }
                                }
                            } elseif (strpos(strtolower($contenido['contenido']), 'radio') !== false || 
                                    strpos(strtolower($contenido['recursos']), 'bbc') !== false ||
                                    strpos(strtolower($contenido['recursos']), 'emisora') !== false) {
                                $tipo = 'Radio';
                                $badgeClass = 'bg-orange';
                                $esAudio = true;
                                
                                if (!empty($contenido['recursos'])) {
                                    $recursos = explode('|', $contenido['recursos']);
                                    $primerRecurso = trim($recursos[0]);
                                    if (filter_var($primerRecurso, FILTER_VALIDATE_URL)) {
                                        $urlAudio = $primerRecurso;
                                    }
                                }
                            } elseif (strpos(strtolower($contenido['contenido']), 'juego') !== false || 
                                    strpos(strtolower($contenido['contenido']), 'quiz') !== false) {
                                $tipo = 'Juego';
                                $badgeClass = 'bg-purple';
                            } else {
                                $tipo = 'Recurso Auditivo';
                                $badgeClass = 'bg-auditivo';
                                $esAudio = true;
                                
                                if (!empty($contenido['recursos'])) {
                                    $recursos = explode('|', $contenido['recursos']);
                                    $primerRecurso = trim($recursos[0]);
                                    if (filter_var($primerRecurso, FILTER_VALIDATE_URL)) {
                                        $urlAudio = $primerRecurso;
                                    }
                                }
                            }
                            
                            // Usar la imagen del contenido o una por defecto
                            $imagen = !empty($contenido['imagen']) ? $contenido['imagen'] : 'https://placehold.co/600x400/2196F3/white?text=Ciencias+Auditivo';
                        ?>
                            <div class="book-card" data-category="<?php echo strtolower($tipo); ?>">
                                <div class="book-cover">
                                    <img src="<?php echo htmlspecialchars($imagen); ?>" 
                                        alt="<?php echo htmlspecialchars($contenido['contenido']); ?>" 
                                        class="img-fluid">
                                    <?php if ($esAudio && !empty($urlAudio)): ?>
                                        <div class="audio-overlay">
                                            <i class="icon-audio">🔊</i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="book-info">
                                    <h5>
                                        <?php if (!empty($contenido['recursos']) && !$esAudio): 
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
                                    
                                    <!-- Botón de reproducción de audio -->
                                    <?php if ($esAudio && !empty($urlAudio)): ?>
                                        <div class="button-action mt-2">
                                            <button class="audio-play-btn" 
                                                    data-audio-url="<?php echo htmlspecialchars($urlAudio); ?>">
                                                Escuchar <i class="icon-onda">🎵</i>
                                            </button>
                                            <audio class="audio-player" preload="none"></audio>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($contenido['recursos']) && !$esAudio): ?>
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
                        <img src="https://placehold.co/600x400/2196F3/white?text=Podcasts" alt="Podcasts" class="img-fluid">
                        <div class="audio-overlay">
                            <i class="icon-audio">🔊</i>
                        </div>
                    </div>
                    <div class="book-info">
                        <h5>Podcasts Científicos</h5>
                        <p class="book-author">Escucha a expertos discutir sobre biología, física y astronomía</p>
                        <span class="badge book-badge bg-auditivo">Podcast</span>
                        <div class="link-list mt-2">
                            <a href="https://www.bbc.co.uk/programmes/p002vsnj" target="_blank" class="recurso-link small">BBC Science in Action</a>
                            <a href="https://nautil.us/podcast/" target="_blank" class="recurso-link small">Nautilus Podcast</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col" data-aos="zoom-in" data-aos-delay="200">
                <div class="book-card">
                    <div class="book-cover">
                        <img src="https://placehold.co/600x400/2196F3/white?text=Conferencias" alt="Conferencias" class="img-fluid">
                        <div class="audio-overlay">
                            <i class="icon-audio">🔊</i>
                        </div>
                    </div>
                    <div class="book-info">
                        <h5>Audiolibros y Conferencias</h5>
                        <p class="book-author">Sumérgete en la narración de temas científicos complejos</p>
                        <span class="badge book-badge bg-blue">Conferencia</span>
                        <div class="link-list mt-2">
                            <a href="https://www.ted.com/talks?topics%5B%5D=science" target="_blank" class="recurso-link small">Charlas TED sobre Ciencia</a>
                            <a href="https://www.audible.com/search?keywords=science+books" target="_blank" class="recurso-link small">Audiolibros de Ciencia</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col" data-aos="zoom-in" data-aos-delay="300">
                <div class="book-card">
                    <div class="book-cover">
                        <img src="https://placehold.co/600x400/2196F3/white?text=Juegos" alt="Juegos" class="img-fluid">
                    </div>
                    <div class="book-info">
                        <h5>Juego: Biología Auditiva</h5>
                        <p class="book-author">Aprende conceptos científicos a través del sonido y la narración</p>
                        <span class="badge book-badge bg-purple">Juego</span>
                        <div class="button-action mt-2">
                            <a href="BioAuditiva/game.php" target="_blank" class="audio-play-btn">
                                Jugar <i class="icon-onda">🎮</i>
                            </a>
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

            // Reproductor de audio
            let audioActual = null;
            let botonActual = null;

            document.querySelectorAll('.audio-play-btn').forEach(function(boton) {
                boton.addEventListener('click', function() {
                    const audioUrl = this.getAttribute('data-audio-url');
                    const audioPlayer = this.nextElementSibling;
                    
                    // Si es el mismo audio, pausar/reanudar
                    if (audioActual === audioPlayer) {
                        if (audioPlayer.paused) {
                            audioPlayer.play();
                            this.innerHTML = 'Pausar <i class="icon-pausa">⏸️</i>';
                            this.classList.add('playing');
                        } else {
                            audioPlayer.pause();
                            this.innerHTML = 'Escuchar <i class="icon-onda">🎵</i>';
                            this.classList.remove('playing');
                        }
                    } else {
                        // Detener audio anterior
                        if (audioActual) {
                            audioActual.pause();
                            audioActual.currentTime = 0;
                            if (botonActual) {
                                botonActual.innerHTML = 'Escuchar <i class="icon-onda">🎵</i>';
                                botonActual.classList.remove('playing');
                            }
                        }
                        
                        // Reproducir nuevo audio
                        audioPlayer.src = audioUrl;
                        audioPlayer.play();
                        this.innerHTML = 'Pausar <i class="icon-pausa">⏸️</i>';
                        this.classList.add('playing');
                        
                        audioActual = audioPlayer;
                        botonActual = this;
                    }
                    
                    // Manejar el fin del audio
                    audioPlayer.onended = function() {
                        botonActual.innerHTML = 'Escuchar <i class="icon-onda">🎵</i>';
                        botonActual.classList.remove('playing');
                        audioActual = null;
                        botonActual = null;
                    };
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