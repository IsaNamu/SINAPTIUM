<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';
include_once HOME_PATH . 'cx/peticiones.php';

include_once HOME_PATH . 'componentes/head_component.php';

$usuarioLogueado = isset($_SESSION['usuario_id']);
$tieneAprendizaje = isset($_SESSION['aprendizaje']) && !empty($_SESSION['aprendizaje']);
$aprendizajeActual = $tieneAprendizaje ? $_SESSION['aprendizaje'] : '';

// Preguntas específicas para Ciencias Naturales
$questions = [
    [
        'question' => "¿Cómo prefieres estudiar el ciclo del agua?",
        'options' => [
            ['text' => "Viendo un diagrama interactivo o una infografía que ilustre todas las etapas del proceso.", 'type' => "visual"],
            ['text' => "Escuchando una explicación narrada o un podcast que describa cada fase del ciclo.", 'type' => "auditivo"],
            ['text' => "Construyendo un modelo pequeño del ciclo o realizando un experimento de condensación.", 'type' => "kinestesico"]
        ]
    ],
    [
        'question' => "¿Qué método te ayuda más a comprender la estructura de una célula?",
        'options' => [
            ['text' => "Observando un modelo 3D detallado o un video animado de sus orgánulos.", 'type' => "visual"],
            ['text' => "Escuchando una descripción verbal de cada parte y su función.", 'type' => "auditivo"],
            ['text' => "Creando una maqueta de la célula con materiales cotidianos como gelatina y dulces.", 'type' => "kinestesico"]
        ]
    ],
    [
        'question' => "¿Cómo prefieres aprender sobre los ecosistemas?",
        'options' => [
            ['text' => "Viendo documentales sobre diferentes biomas y sus especies, con fotos de animales y plantas.", 'type' => "visual"],
            ['text' => "Escuchando a un experto describir los sonidos y relaciones entre las especies en un ecosistema.", 'type' => "auditivo"],
            ['text' => "Simulando un ecosistema en un terrario o visitando un jardín botánico para interactuar con la naturaleza.", 'type' => "kinestesico"]
        ]
    ],
    [
        'question' => "¿Cómo te resulta más fácil aprender las leyes de la física, como la gravedad?",
        'options' => [
            ['text' => "Viendo videos de demostraciones o diagramas que ilustren la fuerza y el movimiento.", 'type' => "visual"],
            ['text' => "Escuchando conferencias o debates que expliquen los principios de forma teórica.", 'type' => "auditivo"],
            ['text' => "Realizando experimentos prácticos, como dejar caer objetos de diferentes pesos y medir su velocidad.", 'type' => "kinestesico"]
        ]
    ],
    [
        'question' => "¿Cuál es la mejor forma para que asimiles las etapas de la fotosíntesis?",
        'options' => [
            ['text' => "Analizando un gráfico que muestra el flujo de energía y los compuestos químicos.", 'type' => "visual"],
            ['text' => "Escuchando una canción o una explicación verbal paso a paso del proceso.", 'type' => "auditivo"],
            ['text' => "Plantando una semilla y observando su crecimiento, o simulando el proceso en un laboratorio virtual.", 'type' => "kinestesico"]
        ]
    ],
];

// Verificar si el usuario ya tiene un estilo de aprendizaje guardado
if ($usuarioLogueado && !$tieneAprendizaje) {
    $usuario_id = $_SESSION['usuario_id'];
    $sql = "SELECT u.*, ma.nombre as metodo_aprendizaje 
            FROM usuario u 
            LEFT JOIN metodos_aprendizaje ma ON u.metodo_aprendizaje_id = ma.id 
            WHERE u.id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        if (!empty($usuario['metodo_aprendizaje'])) {
            $_SESSION['aprendizaje'] = $usuario['metodo_aprendizaje'];
            $_SESSION['metodo_aprendizaje_id'] = $usuario['metodo_aprendizaje_id'];
            $tieneAprendizaje = true;
            $aprendizajeActual = $_SESSION['aprendizaje'];
        }
    }
}

if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    echo "<div class='alert alert-{$mensaje['tipo']} alert-dismissible fade show' role='alert'>
            {$mensaje['texto']}
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
    unset($_SESSION['mensaje']);
}
?>
<!doctype html>
<html lang="es">
<head>
    <?php renderHead('Sinaptium - Ciencias Naturales'); ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/estilos.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/ciencias_naturales.css" >
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
            background: linear-gradient(45deg, #4CAF50, #45a049);
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
            background: linear-gradient(45deg, #4CAF50, #2196F3);
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
        
        /* Estilos específicos para Ciencias Naturales */
        .visual-card {
            background: linear-gradient(135deg, #4CAF50, #8BC34A);
        }
        
        .auditivo-card {
            background: linear-gradient(135deg, #2196F3, #03A9F4);
        }
        
        .kinestesico-card {
            background: linear-gradient(135deg, #FF9800, #FFC107);
        }
    </style>
</head>
<body>    
    <div class="neuronal-background"></div>
    <?php include HOME_PATH . 'componentes/navbar.php'; ?>

    <header class="hero text-center">
        <div class="hero-content">
            <h1>Ciencias Naturales: Explora el Mundo Científico</h1>
            <p class="lead">Descubre la biología, química, física y ecología a través de tu estilo de aprendizaje ideal.</p>
        </div>
    </header>

    <main class="container section-padding">
        <section class="content-card text-center" data-aos="fade-up">
            <h2 class="mb-4">Recursos Personalizados para Ciencias Naturales</h2>
            <p class="subtitle mb-5">Aprende con materiales adaptados a tu forma de aprender</p>
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
                                <h4 class="card-title">Recursos <?php echo ucfirst($tipo); ?>s</h4>
                                <p class="card-text">
                                    <?php
                                    if ($tipo == 'visual') echo 'Si eres visual, aprende con diagramas científicos, videos de experimentos y infografías detalladas.';
                                    elseif ($tipo == 'auditivo') echo 'Si eres auditivo, aprende con podcasts científicos, explicaciones audio y debates de expertos.';
                                    else echo 'Si eres kinestésico, aprende con laboratorios virtuales, experimentos prácticos y modelos manipulables.';
                                    ?>
                                </p>
                                <a href="ciencias_naturales_<?php echo $tipo; ?>.php" class="btn btn-outline-light mt-auto">Descubre Más</a>
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
                        'visual' => 'Si eres visual, aprende con diagramas científicos, videos de experimentos y infografías detalladas.',
                        'auditivo' => 'Si eres auditivo, aprende con podcasts científicos, explicaciones audio y debates de expertos.',
                        'kinestesico' => 'Si eres kinestésico, aprende con laboratorios virtuales, experimentos prácticos y modelos manipulables.',
                        'kinestésico' => 'Si eres kinestésico, aprende con laboratorios virtuales, experimentos prácticos y modelos manipulables.'
                    ];
                ?>
                    <div class="col-md-6">
                        <div class="resource-card <?php echo $aprendizajeActual; ?>-card h-100">
                            <h4 class="card-title">Recursos <?php echo $titulos[$aprendizajeActual]; ?></h4>
                            <p class="card-text"><?php echo $descripciones[$aprendizajeActual]; ?></p>
                            <a href="ciencias_naturales_<?php echo $aprendizajeActual; ?>.php" class="btn btn-outline-light mt-auto">Descubre Más</a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </section>

        <section class="content-card text-center" data-aos="fade-up">
            <h2 class="mb-4">Juego de Ciencias Naturales Educativo</h2>
            <p class="subtitle mb-5">Aprende ciencia mientras juegas con nuestro sistema adaptativo</p>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="resource-card auditivo-card h-100">
                        <h4 class="card-title">Science Quest</h4>
                        <p class="card-text">Potencia tu cerebro científico con neuroeducación</p>
                        <a href="ScienceQuiz/game.php" class="btn btn-game"><span>¡Juega ahora!</span></a>
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
                <h2 class="mb-3">Test de Estilo de Neuroaprendizaje - Ciencias</h2>
                <?php if ($tieneAprendizaje): ?>
                <div class="current-learning-info">
                    <h4>✅ Ya tienes un estilo de aprendizaje detectado</h4>
                    <p class="change-prompt">Tu estilo actual es: <strong><?php echo ucfirst($aprendizajeActual); ?></strong></p>
                    <p class="change-prompt">¿Deseas realizar el test nuevamente para cambiar tu estilo de aprendizaje?</p>
                </div>
                <?php else: ?>
                <p class="instructions">Descubre cómo aprendes mejor ciencia con estas 5 preguntas clave</p>
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
                            <?php echo $tieneAprendizaje ? 'Cambiar mi estilo de aprendizaje' : 'Descubre tu estilo científico'; ?>
                        </span>
                    </button>
                </div>
            </form>
            
            <div id="testResult" class="mt-5 result-card" style="display: none;">
                <h3 class="result-title">¡Hola, <span id="userNameDisplay"></span>!</h3>
                <p class="result-text">Tu estilo de aprendizaje predominante para ciencias es:</p>
                <div class="style-badge" id="detectedStyle">Visual</div>
                <p class="result-text mt-3">Preparando tus recursos científicos personalizados...</p>
                <div class="spinner-border text-light mt-3" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>
        </section>
    </main>

    <?php include HOME_PATH . 'componentes/footer_component.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="../js/ciencias_naturales.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            offset: 50,
        });
    </script>
</body>
</html>