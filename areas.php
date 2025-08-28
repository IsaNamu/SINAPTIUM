<?php
session_start();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sinaptium - Áreas Académicas</title>
    <link href="estilos_bo/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="icon" href="logo/cerebro.svg" type="image/x-icon">
</head>
<body>
    <div class="neuronal-background"></div>

   <?php include 'componentes/navbar.php'; ?>

    <header class="hero-areas">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 data-aos="fade-up">Áreas Académicas</h1>
                    <p class="lead" data-aos="fade-up" data-aos-delay="100">Explora nuestras áreas de conocimiento diseñadas con neurociencia para optimizar tu aprendizaje.</p>
                </div>
            </div>
        </div>
    </header>

    <section class="section-padding">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <div class="col" data-aos="fade-up" data-aos-delay="100">
                <div class="col" data-aos="fade-up" data-aos-delay="200">
                    <div class="area-card text-center">
                        <div class="area-icon">🌎</div>
                        <h3 class="area-title">Inglés</h3>
                        <p class="mb-0">Perfecciona tus habilidades en el idioma global con métodos innovadores.</p>
                        <a href="ingles/ingles.php" class="btn btn-glow mt-3"><span>Explorar</span></a>
                    </div>
                </div>
                <div class="col" data-aos="fade-up" data-aos-delay="300">
                    <div class="area-card text-center">
                        <div class="area-icon">🏛️</div>
                        <h3 class="area-title">Sociales</h3>
                        <p class="mb-0">Comprende la historia, geografía y sociedad a través de experiencias inmersivas.</p>
                        <a href="sociales/sociales.html" class="btn btn-glow mt-3"><span>Explorar</span></a>
                    </div>
                </div>     
            </div>
            <div class="col" data-aos="fade-up" data-aos-delay="400">
                <div class="area-card text-center">
                    <div class="area-icon">🍀</div>
                    <h3 class="area-title">Ciencias Naturales</h3>
                    <p class="mb-0">Explora y aprende sobre física, química y blogía con enfoques neuroeducativos.</p>
                    <a href="ciencias_naturales/ciencias_naturales.php" class="btn btn-glow mt-3"><span>Explorar</span></a>
                </div>
            </div>
            </div>
        </div>
    </section>

    <section class="section-padding bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 data-aos="fade-up">¿Por qué elegir nuestras áreas?</h2>
                    <p class="lead mb-5" data-aos="fade-up" data-aos-delay="100">Cada área está diseñada con principios de neurociencia para maximizar tu retención y comprensión.</p>
                    
                    <div class="row text-start">
                        <div class="col-md-6 mb-4" data-aos="fade-right" data-aos-delay="200">
                            <div class="feature-box">
                                <h3>Enfoque Multisensorial</h3>
                                <p>Aprendizaje que involucra múltiples sentidos para una mejor retención.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4" data-aos="fade-left" data-aos-delay="200">
                            <div class="feature-box">
                                <h3>Adaptación en Tiempo Real</h3>
                                <p>El contenido se ajusta automáticamente a tu ritmo y estilo de aprendizaje.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4" data-aos="fade-right" data-aos-delay="300">
                            <div class="feature-box">
                                <h3>Refuerzo Espaciado</h3>
                                <p>Repaso inteligente en intervalos óptimos para la memoria a largo plazo.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4" data-aos="fade-left" data-aos-delay="300">
                            <div class="feature-box">
                                <h3>Gamificación</h3>
                                <p>Elementos de juego que motivan y hacen el aprendizaje más enjoyable.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-4 mt-5" data-aos="fade-up">
        <div class="container text-center">
            <p class="footer-text">© 2025 Sinaptium. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="estilos_bo/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            offset: 50,
        });
    </script>
</body>
</html>