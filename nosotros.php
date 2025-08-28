<?php
session_start();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sobre Nosotros - Sinaptium</title>
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
            <h1 data-aos="fade-up">¿Por qué creamos Sinaptium?</h1>
            <p class="lead" data-aos="fade-up" data-aos-delay="100">Redefiniendo la educación para cada estilo de aprendizaje a través de la neuroeducación.</p>
        </div>
    </header>

    <section class="section-padding">
        <div class="container">
            <div class="content-card" data-aos="fade-up">
                <h2 class="text-center mb-4 purple">La Razón Detrás del Proyecto</h2>
                <div class="row">
                    <div class="col-lg-6">
                        <p>
                            Durante nuestras clases notamos que muchos compañeros no aprendían al mismo ritmo ni con los mismos métodos. Algunos necesitaban ver, otros hacer, y otros escuchar. Pero el sistema educativo seguía siendo igual para todos.
                        </p>
                        <p>
                            Esto nos hizo reflexionar: ¿por qué no desarrollar una herramienta donde cada estudiante conozca su tipo de aprendizaje y reciba recursos pensados para él?
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p>
                            Así nació Synaptia, nuestro proyecto de grado. Aunque al principio queríamos usar inteligencia artificial, decidimos demostrar que con solo programación básica y ciclos podemos lograr una plataforma útil y transformadora.
                        </p>
                        <p>
                            Basada en los principios de la neurociencia y hecha por estudiantes, para estudiantes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding bg-dark">
        <div class="container">
            <h2 class="text-center mb-5 blue">Nuestra Historia</h2>
            <div class="timeline">
                <div class="timeline-item" data-aos="fade-right">
                    <div class="timeline-content">
                        <span class="timeline-year">2024</span>
                        <h4 class="green">La idea inicial</h4>
                        <p>Tres estudiantes de grado décimo recién iniciando su técnico en programación se reunieron con una misión común: transformar la educación mediante la personalización.</p>
                    </div>
                </div>
                <div class="timeline-item" data-aos="fade-left">
                    <div class="timeline-content">
                        <span class="timeline-year">2024-2025</span>
                        <h4 class="green">Investigación</h4>
                        <p>Desarrollamos los primeros prototipos (en casa) basados en investigaciones sobre estilos de aprendizaje y sistemas adaptativos.</p>
                    </div>
                </div>
                <div class="timeline-item" data-aos="fade-right">
                    <div class="timeline-content">
                        <span class="timeline-year">2024</span>
                        <h4 class="green">Lanzamiento beta</h4>
                        <p>Lanzamos nuestro primer producto con un grupo selecto de estudiantes, observando una mejora del 40% en la retención del conocimiento.</p>
                    </div>
                </div>
                <div class="timeline-item" data-aos="fade-left">
                    <div class="timeline-content">
                        <span class="timeline-year">2025</span>
                        <h4 class="green">Expansión global</h4>
                        <p>Actualmente estamos expandiendo Sinaptium a más instituciones educativas y adaptando nuestro sistema a diferentes culturas y metodologías.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="info-box">
                        <h3 class="blue text-center">Nuestra Misión</h3>
                        <p class="text-center">
                            Desarrollar una plataforma interactiva que permita identificar y potenciar los estilos de aprendizaje de los usuarios a través de herramientas de programación accesibles, promoviendo el aprendizaje personalizado desde la neuroeducación.
                        </p>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left">
                    <div class="info-box">
                        <h3 class="purple text-center">Nuestra Visión</h3>
                        <p class="text-center">
                            Ser una herramienta educativa reconocida en instituciones escolares y técnicas por su innovación, funcionalidad y enfoque neuroeducativo, fomentando el aprendizaje autónomo y eficaz en los estudiantes para el 2027.
                        </p>
                    </div>
                </div>
            </div>

            <h2 class="text-center mt-5 mb-4 purple">Nuestro Equipo</h2>
            <div class="row">
                <div class="col-md-4 col-sm-6" data-aos="fade-up">
                    <div class="team-member">
                        <div class="avatar">AV</div>
                        <h4 class="green">Ana Isabel Vásquez Benítez</h4>
                        <p>Desarrolladora backend</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-member">
                        <div class="avatar">YG</div>
                        <h4 class="green">Yeimar Sebastian Garcia Moreno</h4>
                        <p>Desarrollador frontend</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-member">
                        <div class="avatar">SB</div>
                        <h4 class="green">Ana Sofia Botero Vásquez</h4>
                        <p>Diseño UX</p>
                    </div>
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