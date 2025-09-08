
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Resto del código...
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
}

if (!defined('HOME_PATH')) {
    define('HOME_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');
}

include_once HOME_PATH . 'componentes/head_component.php';
?>
<!doctype html>
<html lang="es">
<head>
    <?php renderHead('Cómo Funciona - Sinaptium'); ?>
    <link href="css/estilos.css" rel="stylesheet">
    <!-- ======= Estilos adicionales ======= -->
    <style>
        /* Botones con brillo y pulsación */
        .btn-neuro {
            position: relative;
            padding: 14px 36px;
            border-radius: 50px;
            font-weight: 600;
            overflow: hidden;
            transition: all .4s ease;
            z-index: 1;
            display: inline-block;
            border: none;
            text-decoration: none;
        }
        .btn-neuro::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--neuro-blue), var(--neuro-purple));
            z-index: -1;
            transition: opacity .4s ease;
        }
        .btn-neuro:hover {
            transform: translateY(-4px);
            box-shadow: 0 0 18px var(--neuro-purple), 0 0 36px var(--neuro-blue);
            color: #fff !important;
        }
        .btn-outline-neuro {
            border: 2px solid var(--neuro-blue);
            color: var(--neuro-blue);
            background: transparent;
        }
        .btn-outline-neuro:hover {
            color: #fff;
            border-color: transparent;
        }

        /* Iconos CRUD animados */
        .crud-icon {
            font-size: 2.5rem;
            margin: .5rem;
            transition: transform .3s ease;
            display: inline-block;
        }
        .crud-icon:hover {
            transform: scale(1.2);
        }
        .doc  { color: var(--neuro-purple); }
        .stud { color: var(--neuro-green); }

        /* Paso 1 & 2: gradiente interno */
        .step-box {
            position: relative;
            border: 1px solid var(--Sinaptium-border);
            border-radius: 20px;
            background: linear-gradient(145deg, rgba(22,22,42,0.9), rgba(42,42,90,0.9));
            overflow: hidden;
            padding: 40px 25px;
            transition: transform .4s ease, box-shadow .4s ease;
        }
        .step-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(79,195,247,.35);
        }
        .step-icon {
            font-size: 3.2rem;
            background: linear-gradient(135deg, var(--neuro-blue), var(--neuro-purple));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 20px;
            display: inline-block;
            transition: transform .5s ease;
        }
        .step-box:hover .step-icon {
            transform: scale(1.25) rotate(5deg);
        }

        /* Separador visual entre secciones */
        .wave-divider {
            height: 80px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%2316162a' fill-opacity='1' d='M0,128L48,138.7C96,149,192,171,288,170.7C384,171,480,149,576,138.7C672,128,768,128,864,149.3C960,171,1056,213,1152,218.7C1248,224,1344,192,1392,176L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E") no-repeat center;
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="neuronal-background"></div>
    <?php include 'componentes/navbar.php'; ?>

    <!-- Hero renovado -->
    <header class="hero">
        <div class="container text-center">
            <h1 data-aos="fade-up">¿Cómo Funciona Sinaptium?</h1>
            <p class="lead" data-aos="fade-up" data-aos-delay="100">
                Aprendizaje personalizado basado en neurociencia para estudiantes y herramientas potentes para docentes
            </p>
        </div>
    </header>

    <!-- PASOS con animaciones -->
    <section class="section-padding">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <!-- Paso 1 -->
                <div class="col-lg-5 col-md-6" data-aos="flip-left">
                    <div class="step-box text-center">
                        <div class="step-icon">1</div>
                        <h3 class="step-title">Diagnóstico Neurosensorial</h3>
                        <p class="mb-0">
                            Un breve cuestionario revela si el estudiante es principalmente
                            <strong>visual, auditivo o kinestésico</strong>.
                        </p>
                    </div>
                </div>

                <!-- Paso 2 -->
                <div class="col-lg-5 col-md-6" data-aos="flip-right" data-aos-delay="200">
                    <div class="step-box text-center">
                        <div class="step-icon">2</div>
                        <h3 class="step-title">Contenido Personalizado</h3>
                        <p class="mb-0">
                            El material cambia automáticamente de formato (videos, lecturas, actividades prácticas)
                            según el perfil detectado.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Iconos visuales -->
            <div class="text-center mt-5" data-aos="fade">
                <span style="font-size: 3.5rem;">👁️</span>
                <span style="font-size: 3.5rem;">👂</span>
                <span style="font-size: 3.5rem;">✋</span>
            </div>
        </div>
    </section>

    <div class="wave-divider"></div>

    <!-- CRUD Docentes / Ver-Estudiantes -->
    <section class="section-padding bg-dark">
        <div class="container">
            <div class="content-card" data-aos="zoom-in">
                <h2 class="text-center mb-4 purple">
                    Sinaptium para Docentes y Estudiantes
                </h2>

                <div class="row g-4">
                    <!-- Card Docente -->
                    <div class="col-md-6">
                        <div class="info-box h-100 text-center p-4">
                            <span class="crud-icon doc">👨‍🏫</span>
                            <h3 class="blue mb-3">Docentes</h3>
                            <p class="mb-3">Control total sobre tus materias:</p>
                            <div class="row row-cols-4 g-2">
                                <div class="col"><span class="crud-icon doc" title="Crear">➕</span><br><small>Crear</small></div>
                                <div class="col"><span class="crud-icon doc" title="Leer">📖</span><br><small>Leer</small></div>
                                <div class="col"><span class="crud-icon doc" title="Actualizar">✏️</span><br><small>Editar</small></div>
                                <div class="col"><span class="crud-icon doc" title="Borrar">🗑️</span><br><small>Borrar</small></div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Estudiante -->
                    <div class="col-md-6">
                        <div class="info-box h-100 text-center p-4">
                            <span class="crud-icon stud">👩‍🎓</span>
                            <h3 class="green mb-3">Estudiantes</h3>
                            <p class="mb-3">Explora y aprende:</p>
                            <div class="row row-cols-2 g-2">
                                <div class="col"><span class="crud-icon stud">👁️‍🗨️</span><br><small>Ver</small></div>
                                <div class="col"><span class="crud-icon stud">✅</span><br><small>Realizar</small></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones renovados -->
                <div class="text-center mt-5">
                    <a href="areas.php" class="btn-neuro me-3">Explora Áreas</a>
                    <a href="biblioteca.php" class="btn-neuro btn-outline-neuro">Biblioteca</a>
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
        AOS.init({ duration: 1000, offset: 50, once: true });
    </script>
</body>
</html>