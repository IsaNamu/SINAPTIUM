<?php
session_start();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cómo Funciona - Sinaptium</title>
    <link rel="icon" href="logo/cerebro.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">
</head>
<body>
    <div class="neuronal-background"></div>

    <?php include 'componentes/navbar.php'; ?>

    <header class="hero">
        <div class="container text-center">
            <h1 data-aos="fade-up">¿Cómo Funciona Sinaptium?</h1>
            <p class="lead" data-aos="fade-up" data-aos-delay="100">Transformamos la educación mediante un proceso neuroadaptativo en 4 pasos</p>
        </div>
    </header>

    <section class="section-padding">
        <div class="container">
            <div class="process-diagram">
                <div class="process-line" data-aos="fade"></div>
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6" data-aos="fade-up">
                        <div class="step-box">
                            <div class="step-icon">1</div>
                            <h3 class="step-title">Test Inicial</h3>
                            <p>Evalúa tu estilo de aprendizaje mediante un test interactivo que analiza tus preferencias cognitivas.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" data-aos="fade-up">
                        <div class="step-box">
                            <div class="step-icon">2</div>
                            <h3 class="step-title">Contenido Dinámico</h3>
                            <p>Nuestro algoritmo personaliza el material educativo según tu perfil, adaptando formatos y metodologías.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="step-box">
                            <div class="step-icon">3</div>
                            <h3 class="step-title">Seguimiento Inteligente</h3>
                            <p>La IA monitorea tu progreso, identifica áreas de mejora y recomienda contenido específico.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="step-box">
                            <div class="step-icon">4</div>
                            <h3 class="step-title">Gamificación</h3>
                            <p>Sistema de recompensas, insignias y niveles que transforman el estudio en una experiencia inmersiva.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding bg-dark">
        <div class="container">
            <div class="content-card" data-aos="fade-up">
                <h2 class="text-center mb-4 purple">La Ciencia Detrás de Sinaptium</h2>
                <div class="row">
                    <div class="col-lg-6">
                        <p>
                            Sinaptium combina los últimos avances en neurociencia cognitiva con algoritmos de inteligencia artificial para crear una experiencia de aprendizaje verdaderamente adaptativa. Nuestra plataforma se basa en investigaciones que demuestran que cada cerebro procesa la información de manera única.
                        </p>
                        <p>
                            El sistema identifica si eres un aprendiz visual, auditivo, kinestésico o lector/escritor, y adapta dinámicamente el contenido para maximizar la retención y comprensión.
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p>
                            A medida que utilizas Sinaptium, el algoritmo refina continuamente su comprensión de tus patrones de aprendizaje, mejorando constantemente la personalización mediante:
                        </p>
                        <ul class="feature-list">
                            <li>Análisis de patrones de interacción</li>
                            <li>Tiempos de respuesta y retención</li>
                            <li>Preferencias de formato de contenido</li>
                            <li>Efectividad de metodologías aplicadas</li>
                        </ul>
                    </div>
                </div>
                
                <div class="row mt-5">
                    <h3 class="text-center mb-4 orange">Características Principales</h3>
                    
                    <div class="col-md-6" data-aos="fade-right">
                        <div class="feature-box">
                            <h3>Neuroadaptabilidad</h3>
                            <p>Contenido que evoluciona según tus patrones neurocognitivos, facilitando la formación de nuevas conexiones sinápticas.</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6" data-aos="fade-left">
                        <div class="feature-box">
                            <h3>Memoria Espaciada</h3>
                            <p>Programación inteligente de repasos basada en la curva del olvido, optimizando la retención a largo plazo.</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6" data-aos="fade-right" data-aos-delay="100">
                        <div class="feature-box">
                            <h3>Análisis Cognitivo</h3>
                            <p>Evaluación continua de tus fortalezas y debilidades para ajustar el contenido en tiempo real.</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6" data-aos="fade-left" data-aos-delay="100">
                        <div class="feature-box">
                            <h3>Integración Multimodal</h3>
                            <p>Combinación estratégica de elementos visuales, auditivos y kinestésicos para un aprendizaje holístico.</p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-5">
                    <a href="areas.php" class="btn btn-glow btn-lg me-3">Explora Áreas</a>
                    <a href="biblioteca.php" class="btn btn-outline-light btn-lg">Biblioteca</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-4 mt-5">
        <div class="container text-center">
            <p class="footer-text">© 2025 Sinaptium. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            offset: 50,
            once: true
        });
    </script>
</body>
</html>