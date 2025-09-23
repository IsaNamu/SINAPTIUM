<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';
include_once HOME_PATH . 'cx/peticiones.php';

include_once HOME_PATH . 'componentes/head_component.php';
?>
<!doctype html>
<html lang="es">
<head>
    <?php renderHead('Sinaptium - Sociales (Auditivo)'); ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/estilos.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/sociales.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/ingles.css" >
</head>
<body>    
    <div class="neuronal-background"></div>
    <?php include HOME_PATH . 'componentes/navbar.php'; ?>

    <header class="hero text-center text-white py-5">
        <div class="container" data-aos="fade-up">
            <h1 class="auditivo-color">Sociales: Recursos para Aprendices Auditivos</h1>
            <p class="lead">Si aprendes mejor escuchando, estas fuentes de audio te ayudarán a entender las Ciencias Sociales.</p>
            <a href="sociales.php" class="btn btn-outline-light mt-3">Volver al Test de Sociales</a>
        </div>
    </header>
        <main class="container my-5">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                
                <!-- Tarjeta 1: Podcasts de Neurociencia y Sociales -->
                <div class="col" data-aos="zoom-in" data-aos-delay="100">
                    <div class="auditory-card">
                        <!-- Icono de podcast, simulado con SVG -->
                        <svg class="card-icon mx-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10 10 10 0 0 0 10-10A10 10 0 0 0 12 2z"></path>
                            <path d="M12 16V8"></path>
                            <path d="M8 12h8"></path>
                        </svg>
                        <div class="card-body text-center">
                            <h4 class="card-title">Podcasts para Conectar Neuronas</h4>
                            <p class="card-text">Escuchar narraciones y debates activa las redes neuronales del lenguaje y la memoria, ayudándote a crear conexiones mentales duraderas con los temas de historia y actualidad.</p>
                            <ul class="link-list">
                                <li><a href="https://www.spotify.com/podcast/math_explained3" target="_blank">"La Rosa de los Vientos" (Onda Cero)</a></li>
                                <li><a href="https://www.spotify.com/podcast/math_explained4" target="_blank">"Aprende Historia con Antonio"</a></li>
                                <li><a href="https://www.npr.org/podcasts/510313/up-first" target="_blank">NPR Up First</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
    
                <!-- Tarjeta 2: Conferencias para la Absorción del Conocimiento -->
                <div class="col" data-aos="zoom-in" data-aos-delay="200">
                    <div class="auditory-card">
                        <!-- Icono de conferencia, simulado con SVG -->
                        <svg class="card-icon mx-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2a10 10 0 0 0-9.2 13.5c.3.5.7 1.1 1.2 1.5l1.6 1.3c.5.4 1.2 1.5 2 2.7 1.2 1.7 2.6 3.3 4.4 3.3s3.2-1.6 4.4-3.3c.8-1.2 1.5-2.3 2-2.7l1.6-1.3c.5-.4.9-1 1.2-1.5A10 10 0 0 0 12 2z"></path>
                        </svg>
                        <div class="card-body text-center">
                            <h4 class="card-title">Charlas que Despiertan la Curiosidad</h4>
                            <p class="card-text">Las conferencias estimulan la atención sostenida. Escuchar a expertos en un solo tema ayuda a tu cerebro a concentrarse y retener información clave, formando "caminos" más fuertes para el conocimiento.</p>
                            <ul class="link-list">
                                <li><a href="https://www.ted.com/topics/social+science" target="_blank">TED Talks sobre Ciencias Sociales</a></li>
                                <li><a href="https://www.ted.com/topics/history" target="_blank">TED Talks sobre Historia</a></li>
                                <li><a href="http://googleusercontent.com/youtube.com/15" target="_blank">Conferencias Completas de Universidades (YouTube)</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
    
                <!-- Tarjeta 3: Audiolibros para la Imaginación y el Enfoque -->
                <div class="col" data-aos="zoom-in" data-aos-delay="300">
                    <div class="auditory-card">
                        <!-- Icono de audiolibro, simulado con SVG -->
                        <svg class="card-icon mx-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21V5a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16"></path>
                            <path d="M12 18v3"></path>
                            <path d="M12 13v5"></path>
                            <path d="M12 8v5"></path>
                            <path d="M12 3v5"></path>
                        </svg>
                        <div class="card-body text-center">
                            <h4 class="card-title">Audiolibros que Fortalecen la Memoria</h4>
                            <p class="card-text">El cerebro auditivo procesa la narrativa de forma secuencial. Al escuchar audiolibros, entrenas tu capacidad de seguir un hilo de información complejo, lo cual es fundamental para el aprendizaje de conceptos históricos y sociológicos.</p>
                            <ul class="link-list">
                                <li><a href="https://www.audible.com/" target="_blank">Audible</a></li>
                                <li><a href="https://librivox.org/search?q=history&search_form=advanced" target="_blank">LibriVox (Historia y Ciencias Sociales)</a></li>
                                <li><a href="https://open.spotify.com/genre/audiobooks-nonfiction-browse" target="_blank">Audiolibros de No Ficción en Spotify</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
    
                <!-- Tarjeta 4: Noticias y Análisis de Radio para la Atención -->
                <div class="col" data-aos="zoom-in" data-aos-delay="400">
                    <div class="auditory-card">
                        <!-- Icono de radio, simulado con SVG -->
                        <svg class="card-icon mx-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 12v3"></path>
                            <path d="M14 12v3"></path>
                            <path d="M4 14v1"></path>
                            <path d="M20 14v1"></path>
                            <path d="M12 21a9 9 0 0 0 9-9c0-6.2-7.8-11.4-12-8.5-4.2-2.9-12 2.3-12 8.5a9 9 0 0 0 9 9z"></path>
                            <path d="M12 17c-2.2 0-4-1.8-4-4s1.8-4 4-4 4 1.8 4 4-1.8 4-4 4z"></path>
                            <path d="M8 12h8"></path>
                        </svg>
                        <div class="card-body text-center">
                            <h4 class="card-title">La Radio para la Atención Selectiva</h4>
                            <p class="card-text">Escuchar análisis de noticias te ayuda a entrenar tu capacidad de atención selectiva, un proceso clave para filtrar información relevante y construir una comprensión detallada del mundo que te rodea.</p>
                            <ul class="link-list">
                                <li><a href="https://www.bbc.co.uk/programmes/p002tn57/episodes/downloads" target="_blank">BBC World Service (Newscast)</a></li>
                                <li><a href="https://www.radioplay.es/emisoras" target="_blank">Radio Española (Noticias y Debates)</a></li>
                                <li><a href="https://tunein.com/radio/News-Talk-g1/" target="_blank">TuneIn Radio (News & Talk)</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Tarjeta 5: Juego Interactivo "SocioQuiz" -->
                <div class="col" data-aos="zoom-in" data-aos-delay="500">
                    <div class="auditory-card game-card">
                        <!-- Icono de juego, simulado con SVG -->
                        <svg class="card-icon mx-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                            <path d="M15 2H9a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z"></path>
                            <path d="M12 10v4"></path>
                            <path d="M10 12h4"></path>
                        </svg>
                        <div class="card-body text-center">
                            <h4 class="card-title">Juego: SocioQuiz</h4>
                            <p class="card-text">La gamificación y el aprendizaje auditivo combinados. A través de un quiz interactivo, tu cerebro se beneficia de la retroalimentación inmediata, lo que refuerza las conexiones neuronales y consolida el conocimiento de manera divertida y efectiva.</p>
                            <a href="SocioQuiz/game.html" target="_blank" class="btn btn-glow mt-auto">¡Juega con toda la actitud!</a>
                        </div>
                    </div>
                </div>
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