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
    <style>
/* ======= Timeline 2025 ======= */
.timeline-2025 {
    position: relative;
    max-width: 840px;
    margin: 0 auto;
}
.timeline-2025::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(to bottom, var(--neuro-blue), var(--neuro-purple));
    transform: translateX(-50%);
}
.timeline-card {
    position: relative;
    width: 46%;
    padding: 25px;
    margin-bottom: 40px;
    border-radius: 20px;
    background: rgba(22,22,42,.85);
    border: 1px solid var(--Sinaptium-border);
    box-shadow: 0 8px 20px rgba(0,0,0,.3);
    backdrop-filter: blur(6px);
    transition: transform .4s ease, box-shadow .4s ease;
}
.timeline-card:nth-child(odd) { margin-right: auto; }
.timeline-card:nth-child(even) { margin-left: auto; }
.timeline-card:hover {
    transform: scale(1.03);
    box-shadow: 0 0 25px var(--neuro-purple);
}
.timeline-date {
    display: inline-block;
    font-size: .9rem;
    font-weight: 700;
    background: linear-gradient(90deg,var(--neuro-blue),var(--neuro-purple));
    -webkit-background-clip: text;
    color: transparent;
}
.timeline-icon {
    position: absolute;
    top: 20px;
    font-size: 2rem;
    line-height: 1;
}
.timeline-card:nth-child(odd) .timeline-icon { right: -55px; }
.timeline-card:nth-child(even) .timeline-icon { left: -55px; }
@media (max-width: 768px) {
    .timeline-2025::before { left: 30px; }
    .timeline-card { width: calc(100% - 60px); margin-left: 60px !important; }
    .timeline-icon { left: -55px !important; right: auto !important; }
}
</style>
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
            <h2 class="text-center mb-5 blue">Nuestra travesía</h2>

            <div class="timeline-2025">
                <!-- Febrero -->
                <div class="timeline-card" data-aos="fade-right">
                    <span class="timeline-icon">🌱</span>
                    <span class="timeline-date">Febrero 2025</span>
                    <h4 class="green">La semilla en casa</h4>
                    <p>Con PHP y mucho esfuerzo, empezamos a codificar Sinaptium en nuestros cuartos, soñando con una manera de estudiar, aprender y enseñar distinto y único.</p>
                </div>

                <!-- Abril -->
                <div class="timeline-card" data-aos="fade-left">
                    <span class="timeline-icon">🔍</span>
                    <span class="timeline-date">Abril 2025</span>
                    <h4 class="green">Observar para entender</h4>
                    <p>Investigamos muucho sobre la neurociencia, para así poder mostrar que solo hay un tipo de aprendizaje, sino que cada persona tiene su manera de aprender, la cual es muy distinta dependiendo de como aprendamos las cosas, ya que cada persona tiene habilidades distintas.</p>
                </div>

                <!-- Junio -->
                <div class="timeline-card" data-aos="fade-right">
                    <span class="timeline-icon">⚙️</span>
                    <span class="timeline-date">Junio 2025</span>
                    <h4 class="green">Código con cariño</h4>
                    <p>Convertimos ciclos y condicionales en rutas visuales, auditivas y kinestésicas: ¡Sinaptium tomaba mucha más forma e identidad!</p>
                </div>

                <!-- Agosto -->
                <div class="timeline-card" data-aos="fade-left">
                    <span class="timeline-icon">🧪</span>
                    <span class="timeline-date">Agosto 2025</span>
                    <h4 class="green">Pruebas llenas de emociones</h4>
                    <p>Siempre moestrandole nuestros avances a los docentes, los cuales siempre nos guiaban.</p>
                </div>

                <!-- Octubre -->
                <div class="timeline-card" data-aos="fade-right">
                    <span class="timeline-icon">🚀</span>
                    <span class="timeline-date">Octubre 2025</span>
                    <h4 class="green">Llegamos para quedarnos</h4>
                    <p>Con corazón y código abierto, lanzamos Sinaptium al mundo para que cada estudiante encuentre su camino y así poderselo a el SENA, quien siempre nos brindo nuestros conocimientos para poder crear Sinaptium.</p>
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