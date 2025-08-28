<?php
session_start();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sinaptium - Inicio</title>
    <link href="estilos_bo/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="icon" href="logo/cerebro.svg" type="image/x-icon">
</head>
<body>
    <div class="neuronal-background"></div>

    <?php include 'componentes/navbar.php'; ?>  

    <header class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h1>Bienvenido a Sinaptium</h1>
                    <p class="lead">Impulsando el aprendizaje mediante neurociencia e inteligencia artificial.</p>
                    <a href="areas.php" class="btn btn-glow"><span>Explorar</span></a>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="interactive-brain">
                        <svg viewBox="0 0 300 300" aria-label="Representación gráfica de conexiones neuronales">
                            <path class="brain-path" d="M150 50 Q100 150, 150 250 Q200 150, 150 50" />
                            <circle cx="150" cy="150" r="100" stroke="var(--neuro-green)" stroke-width="2" fill="none" />
                            <line x1="120" y1="100" x2="180" y2="200" stroke="var(--neuro-orange)" stroke-width="2" />
                            <circle cx="150" cy="150" r="10" fill="var(--neuro-purple)" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4" data-aos="fade-right">
                    <div class="feature-item">
                        <h3 class="purple">Aprendizaje Personalizado</h3>
                        <p class="mb-0">Avanza con herramientas diseñadas según tu estilo único.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up">
                    <div class="feature-item">
                        <h3 class="blue">Eficiencia Máxima</h3>
                        <p class="mb-0">Mejora constantemente con inteligencia ajustable a tiempo real.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-left">
                    <div class="feature-item">
                        <h3 class="green">Visión del Futuro</h3>
                        <p class="mb-0">Forma parte de la próxima evolución en la educación.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="testimonials">
        <div class="container">
            <h2 class="text-center mb-5">Lo que dicen nuestros usuarios</h2>
            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <p class="text-center text-primary fs-4">"Sinaptium revolucionó la forma en que aprendo, ¡es increíble!"</p>
                    </div>
                    <div class="carousel-item">
                        <p class="text-center text-success fs-4">"Una experiencia educativa personalizada como ninguna otra."</p>
                    </div>
                    <div class="carousel-item">
                        <p class="text-center text-warning fs-4">"No puedo imaginar mi vida estudiando sin Sinaptium."</p>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
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