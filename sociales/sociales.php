<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';
include_once HOME_PATH . 'cx/peticiones.php';

include_once HOME_PATH . 'componentes/head_component.php';

$usuarioLogueado = isset($_SESSION['usuario_id']);
$tieneAprendizaje = isset($_SESSION['aprendizaje']) && !empty($_SESSION['aprendizaje']);
$aprendizajeActual = $tieneAprendizaje ? $_SESSION['aprendizaje'] : '';

$questions = [
    [
        'question' => "¿Cómo prefieres estudiar eventos históricos complejos?",
        'options' => [
            ['text' => "Viendo líneas de tiempo interactivas, mapas históricos o documentales visuales.", 'type' => "visual"],
            ['text' => "Escuchando podcasts de historia, audiodramas o debates de expertos.", 'type' => "auditivo"],
            ['text' => "Creando maquetas de batallas, visitando museos o recreando momentos históricos.", 'type' => "kinestesico"]
        ]
    ],
    [
        'question' => "¿Qué método te ayuda más a comprender la geografía física y política?",
        'options' => [
            ['text' => "Estudiando mapas detallados, globos terráqueos o imágenes satelitales.", 'type' => "visual"],
            ['text' => "Escuchando descripciones de paisajes, nombres de lugares y características geográficas.", 'type' => "auditivo"],
            ['text' => "Construyendo modelos de terreno, maquetas de ciudades o realizando excursiones geográficas.", 'type' => "kinestesico"]
        ]
    ],
    [
        'question' => "¿Cómo prefieres aprender sobre diferentes culturas y sociedades?",
        'options' => [
            ['text' => "Viendo fotografías, videos de viajes o exposiciones de arte de otras culturas.", 'type' => "visual"],
            ['text' => "Escuchando música tradicional, entrevistas con personas de otras culturas o relatos orales.", 'type' => "auditivo"],
            ['text' => "Participando en festivales culturales, cocinando platos típicos o aprendiendo danzas tradicionales.", 'type' => "kinestesico"]
        ]
    ],
    [
        'question' => "¿Al analizar problemas sociales o económicos, qué enfoque prefieres?",
        'options' => [
            ['text' => "Estudiando gráficos, estadísticas, infografías o diagramas de flujo de procesos económicos.", 'type' => "visual"],
            ['text' => "Escuchando análisis económicos de expertos, debates sobre políticas sociales o programas de radio.", 'type' => "auditivo"],
            ['text' => "Participando en simulaciones de mercado, juegos de roles sobre políticas o visitando empresas/ONGs.", 'type' => "kinestesico"]
        ]
    ],
    [
        'question' => "¿Cómo te sientes más cómodo al preparar un proyecto o presentación de Sociales?",
        'options' => [
            ['text' => "Diseñando presentaciones con muchas imágenes, mapas o videos, y usando gráficos impactantes.", 'type' => "visual"],
            ['text' => "Practicando la presentación en voz alta, grabando mi voz o escuchando grabaciones de discursos.", 'type' => "auditivo"],
            ['text' => "Creando materiales interactivos, realizando dramatizaciones o moviéndome mientras presento.", 'type' => "kinestesico"]
        ]
    ],
];
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
        
        .current-learning-info {
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            color: white;
            text-align: center;
        }
        
        .change-prompt {
            font-size: 1.1rem;
            margin-top: 10px;
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

    <main class="container section-padding">
        <section class="content-card text-center" data-aos="fade-up">
            <h2 class="mb-4">Juego de Sociales Educativo</h2>
            <p class="subtitle mb-5">Aprende mientras juegas con nuestro sistema adaptativo</p>
            <div class="row justify-content-center">
                <?php
                // Verificar si la variable de sesión 'aprendizaje' existe y tiene valor
                if (!$tieneAprendizaje) {
                    // Mostrar los tres divs si no hay valor
                    $tipos = ['visual', 'auditivo', 'kinestesico'];
                    foreach ($tipos as $index => $tipo) {
                        $mt4 = ($index == 2) ? 'mt-4' : ''; // Agregar margen solo al último
                ?>
                        <div class="col-md-6 <?php echo $mt4; ?>">
                            <div class="resource-card <?php echo $tipo; ?>-card h-100">
                                <h4 class="card-title">Recursos <?php echo ucfirst($tipo); ?></h4>
                                <p class="card-text">
                                    <?php
                                    if ($tipo == 'visual') echo 'Si eres visual, aprende con mapas mentales, infografías y vídeos con subtítulos.';
                                    elseif ($tipo == 'auditivo') echo 'Si eres auditivo, aprende con podcasts, canciones y audiolibros.';
                                    else echo 'Si eres kinestésico, aprende con juegos de rol, actividades de escritura y tarjetas de memoria.';
                                    ?>
                                </p>
                                <a href="sociales_<?php echo $tipo; ?>.php" class="btn btn-outline-light mt-auto">Descubre Más</a>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    // Mostrar solo el div correspondiente al tipo de aprendizaje
                    $titulos = [
                        'visual' => 'Visuales',
                        'auditivo' => 'Auditivos', 
                        'kinestesico' => 'Kinestésicos',
                        'kinestésico' => 'Kinestésicos'
                    ];
                    
                    $descripciones = [
                        'visual' => 'Si eres visual, aprende con mapas mentales, infografías y vídeos con subtítulos.',
                        'auditivo' => 'Si eres auditivo, aprende con podcasts, canciones y audiolibros.',
                        'kinestesico' => 'Si eres kinestésico, aprende con juegos de rol, actividades de escritura y tarjetas de memoria.',
                        'kinestésico' => 'Si eres kinestésico, aprende con juegos de rol, actividades de escritura y tarjetas de memoria.'
                    ];
                ?>
                    <div class="col-md-6">
                        <div class="resource-card <?php echo $aprendizajeActual; ?>-card h-100">
                            <h4 class="card-title">Recursos <?php echo $titulos[$aprendizajeActual]; ?></h4>
                            <p class="card-text"><?php echo $descripciones[$aprendizajeActual]; ?></p>
                            <a href="sociales_<?php echo $aprendizajeActual; ?>.php" class="btn btn-outline-light mt-auto">Descubre Más</a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </section>

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
                <?php if ($tieneAprendizaje): ?>
                <div class="current-learning-info">
                    <h4>✅ Ya tienes un estilo de aprendizaje detectado</h4>
                    <p class="change-prompt">Tu estilo actual es: <strong><?php echo ucfirst($aprendizajeActual); ?></strong></p>
                    <p class="change-prompt">¿Deseas realizar el test nuevamente para cambiar tu estilo de aprendizaje?</p>
                </div>
                <?php else: ?>
                <p class="instructions">Descubre cómo aprendes mejor con estas 5 preguntas clave</p>
                <?php endif; ?>
            </div>
            
            <form id="learningStyleTest" class="mt-4" <?php echo !$usuarioLogueado ? 'style="opacity: 0.3; pointer-events: none;"' : ''; ?>>
                <div id="testQuestions" class="text-start">
                    <?php foreach ($questions as $i => $q): ?>
                        <div class="question-card mb-4">
                            <p class="question-text"><?php echo ($i + 1) . '. ' . $q['question']; ?></p>
                            <?php foreach ($q['options'] as $optIndex => $option): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question<?php echo $i; ?>" 
                                        id="q<?php echo $i; ?>o<?php echo $optIndex; ?>" 
                                        value="<?php echo $option['type']; ?>" 
                                        <?php echo !$usuarioLogueado ? 'disabled' : ''; ?> required>
                                    <label class="form-check-label" for="q<?php echo $i; ?>o<?php echo $optIndex; ?>">
                                        <?php echo $option['text']; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="user-input mt-5">
                    <?php if ($usuarioLogueado): ?>
                        <div class="welcome-message mb-4">
                            <h4 class="text-center text-light">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h4>
                            <?php if ($tieneAprendizaje): ?>
                                <p class="text-center text-light">Estilo actual: <?php echo ucfirst($aprendizajeActual); ?></p>
                            <?php endif; ?>
                        </div>
                        <input type="hidden" id="userName" value="<?php echo htmlspecialchars($_SESSION['usuario']); ?>">
                    <?php else: ?>
                        <div class="mb-4">
                            <label for="userName" class="form-label">Nombre o alias:</label>
                            <input type="text" class="form-control text-center mx-auto" id="userName" name="userName" required style="max-width: 300px;" disabled>
                        </div>
                    <?php endif; ?>
                    
                    <button type="submit" class="btn btn-glow" <?php echo !$usuarioLogueado ? 'disabled' : ''; ?>>
                        <span>
                            <?php echo $tieneAprendizaje ? 'Cambiar mi estilo de aprendizaje' : 'Descubre tu estilo'; ?>
                        </span>
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
    <script src="../js/sociales.js"></script>
</body>
</html>