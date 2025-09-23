<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';
include_once HOME_PATH . 'cx/peticiones.php';

include_once HOME_PATH . 'componentes/head_component.php';

$usuarioLogueado = isset($_SESSION['usuario_id']);
?>
<!doctype html>
<html lang="es">
<head>
    <?php renderHead('Sinaptium - Sociales'); ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/estilos.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/sociales.css" >
    <style>
        .test-overlay {
            position: relative;
        }
        
        .test-blocker {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 10;
            border-radius: 15px;
            color: white;
        }
        
        .lock-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        .login-prompt {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            padding: 0 1rem;
        }
        
        .btn-login {
            margin-top: 1rem;
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            color: white;
            font-weight: bold;
            text-decoration: none;
            transition: transform 0.3s ease;
        }
        
        .btn-login:hover {
            transform: scale(1.05);
            color: white;
        }
    </style>
</head>
<body>    
    <div class="neuronal-background"></div>
    <?php include HOME_PATH . 'componentes/navbar.php'; ?>

    <header class="hero text-center">
        <div class="hero-content">
            <h1>Sociales: Explora el Mundo y sus Culturas</h1>
            <p class="lead">Comprende la historia, geografía y las sociedades humanas a través de tu enfoque de aprendizaje ideal.</p>
        </div>
    </header>

     <!-- Aqui se colocaran los juegos -->

    <main class="container section-padding">
        <section class="content-card text-center" data-aos="fade-up">
            <h2 class="mb-4">Juego de Sociales Educativo</h2>
            <p class="subtitle mb-5">Aprende mientras juegas con nuestro sistema adaptativo</p>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="resource-card visual-card h-100">
                        <h4 class="card-title">Recursos Visuales</h4>
                        <p class="card-text">Si eres visual, aprende con mapas mentales, infografías y vídeos con subtítulos.</p>
                        <a href="sociales_visual.php" class="btn btn-outline-light mt-auto">Descubre Más</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="resource-card auditivo-card h-100">
                        <h4 class="card-title">Recursos Auditivos</h4>
                        <p class="card-text">Si eres auditivo, aprende con podcasts, canciones y audiolibros.</p>
                        <a href="sociales_auditivo.php" class="btn btn-outline-light mt-auto">Descubre Más</a>
                    </div>
                </div>
                <div class="col-md-6 mt-4">
                    <div class="resource-card kinestesico-card h-100">
                        <h4 class="card-title">Recursos Kinestésicos</h4>
                        <p class="card-text">Si eres kinestésico, aprende con juegos de rol, actividades de escritura y tarjetas de memoria.</p>
                        <a href="sociales_kinestesico.php" class="btn btn-outline-light mt-auto">Descubre Más</a>
                    </div>
                </div>
            </div>
        </section>

    <main class="container section-padding">
        <section class="content-card text-center" data-aos="fade-up">
            <h2 class="mb-4">Juego de Sociales Educativo</h2>
            <p class="subtitle mb-5">Aprende mientras juegas con nuestro sistema adaptativo</p>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="resource-card auditivo-card h-100">
                        <h4 class="card-title">Socio Quest</h4>
                        <p class="card-text">Potencia tu cerebro historico con neuroeducación</p>
                        <a href="SocioQuiz/game.php" class="btn btn-game"><span>¡Juega ahora!</span></a>
                    </div>
                </div>
            </div>
        </section>

        <section id="test-neuroaprendizaje" class="content-card text-center mt-5 test-overlay" data-aos="fade-up">
            <?php if (!$usuarioLogueado): ?>
            <div class="test-blocker">
                <div class="lock-icon">🔒</div>
                <div class="login-prompt">Iniciar Sesión</div>
                <p class="mt-2">Debes iniciar sesión para realizar el test</p>
                <a href="<?php echo BASE_URL; ?>login" class="btn-login">Iniciar Sesión</a>
            </div>
            <?php endif; ?>
            
            <div class="test-header">
                <h2 class="mb-3">Test de Estilo de Neuroaprendizaje</h2>
                <p class="instructions">Descubre cómo aprendes mejor con estas 4 preguntas clave</p>
            </div>
            
            <form id="learningStyleTest" class="mt-4" <?php echo !$usuarioLogueado ? 'style="opacity: 0.3; pointer-events: none;"' : ''; ?>>
                <div id="testQuestions" class="text-start">
                    <!-- Preguntas generadas por JS -->
                    <div class="question-card mb-4">
                        <p class="question-text">1. ¿Cómo prefieres estudiar eventos históricos complejos?</p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q1" id="q1a" value="visual" <?php echo !$usuarioLogueado ? 'disabled' : ''; ?>>
                            <label class="form-check-label" for="q1a">Ver gráficos y diagramas</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q1" id="q1b" value="auditivo" <?php echo !$usuarioLogueado ? 'disabled' : ''; ?>>
                            <label class="form-check-label" for="q1b">Escuchar explicaciones</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q1" id="q1c" value="kinestesico" <?php echo !$usuarioLogueado ? 'disabled' : ''; ?>>
                            <label class="form-check-label" for="q1c">Manipular objetos físicos</label>
                        </div>
                    </div>
                    
                    <div class="question-card mb-4">
                        <p class="question-text">2. ¿Qué método te ayuda más a comprender la geografía física y política?</p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q2" id="q2a" value="visual" <?php echo !$usuarioLogueado ? 'disabled' : ''; ?>>
                            <label class="form-check-label" for="q2a">Ver ejemplos resueltos</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q2" id="q2b" value="auditivo" <?php echo !$usuarioLogueado ? 'disabled' : ''; ?>>
                            <label class="form-check-label" for="q2b">Que me expliquen paso a paso</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q2" id="q2c" value="kinestesico" <?php echo !$usuarioLogueado ? 'disabled' : ''; ?>>
                            <label class="form-check-label" for="q2c">Intentar resolverlo yo mismo</label>
                        </div>
                    </div>
                </div>
                
                <div class="user-input mt-5">
                    <?php if ($usuarioLogueado): ?>
                        <div class="welcome-message mb-4">
                            <h4 class="text-center text-light">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h4>
                        </div>
                    <?php else: ?>
                        <div class="mb-4">
                            <label for="userName" class="form-label">Nombre o alias:</label>
                            <input type="text" class="form-control text-center mx-auto" id="userName" name="userName" required style="max-width: 300px;" disabled>
                        </div>
                    <?php endif; ?>
                    
                    <button type="submit" class="btn btn-glow" <?php echo !$usuarioLogueado ? 'disabled' : ''; ?>>
                        <span>Descubre tu estilo</span>
                    </button>
                </div>
            </form>
            
            <div id="testResult" class="mt-5 result-card" style="display: none;">
                <h3 class="result-title">¡Hola, <span id="userNameDisplay"></span>!</h3>
                <p class="result-text">Tu estilo de aprendizaje predominante es:</p>
                <div class="style-badge" id="detectedStyle">Visual</div>
                <p class="result-text mt-3">Preparando tus recursos personalizados...</p>
                <div class="spinner-border text-light mt-3" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>
        </section>
    </main>

    <?php include HOME_PATH . 'componentes/footer_component.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            offset: 50,
        });
        </script>
    <script>
        const USER_NAME_PHP = '<?php echo $usuarioLogueado ? htmlspecialchars($_SESSION['usuario']) : ""; ?>';
    </script>
    <script src="../js/sociales.js"></script>
</body>
</html>