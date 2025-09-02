<?php
// login.php - Agregar esto al principio del archivo, antes de <!doctype html>
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
}

if (!defined('HOME_PATH')) {
    define('HOME_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');
}

// Si el usuario ya está logueado, redirigirlo a la página principal
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: " . BASE_URL . "index.php");
    exit;
}
if (isset($_SESSION['mensaje'])) {
    if (is_array($_SESSION['mensaje'])) {
        $mensaje = $_SESSION['mensaje'];
    } else {
        echo $_SESSION['mensaje'];
    }
}
include_once HOME_PATH . 'componentes/head_component.php';
?>
<!doctype html>
<html lang="es">
<head>
    <?php renderHead('Sinaptium - Iniciar Sesión'); ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/dashboard.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/estilos.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/login.css">
</head>
<body>
    <div class="neuronal-background"></div>

    <!-- Navegación mínima -->
    <nav class="navbar-minimal">
        <div class="container">
            <a href="<?php echo BASE_URL; ?>index.php" class="back-home">
                <span>←</span> Volver al Inicio
            </a>
        </div>
    </nav>

    <!-- Contenedor del Login -->
    <div class="login-container">
        <div class="loginbox" data-aos="fade-up">
            <div class="alert-container">
                <?php
                // Mostrar el mensaje que asignamos al principio
                if (isset($mensaje)) {
                    if (is_array($mensaje)) {
                        echo "<div class='alert alert-{$mensaje['tipo']} alert-dismissible fade show' role='alert'>
                                {$mensaje['texto']}
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                    } else {
                        // Si es string, mostrarlo directamente
                        echo $mensaje;
                    }
                    // FINALMENTE limpiar la variable de sesión
                    unset($_SESSION['mensaje']);
                }
                ?>
            </div>
            <img src="<?php echo BASE_URL; ?>logo/logo.svg" class="avatar" alt="Sinaptium Logo">
            <h1>Iniciar Sesión</h1>
            
            <form method="POST" action="<?php echo BASE_URL; ?>login/controlador.php">
                <div class="input-wrapper">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" placeholder="Ingrese su usuario" required>
                </div>
                
                <div class="input-wrapper">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Ingrese su contraseña" required>
                </div>
                
                <input type="submit" value="Iniciar Sesión">
                
                <a href="#">¿Olvidaste tu contraseña?</a>
            </form>

            <div class="register-link">
                <p>¿No tienes una cuenta?</p>
                <a href="<?php echo BASE_URL; ?>register/register.php">Crear cuenta nueva</a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?php echo BASE_URL; ?>estilos_bo/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    
    <script>
        // Inicializar AOS
        AOS.init({
            duration: 800,
            offset: 50,
        });

        // Efectos visuales adicionales
        document.querySelectorAll('input[type="text"], input[type="password"]').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });


        // CSS para la animación de partículas
        const style = document.createElement('style');
        style.textContent = `
            @keyframes float {
                0% { transform: translateY(0px) rotate(0deg); opacity: 0.1; }
                100% { transform: translateY(-20px) rotate(180deg); opacity: 0.3; }
            }
        `;
        document.head.appendChild(style);

        for (let i = 0; i < 30; i++) {
                const particle = document.createElement('div');
                particle.style.cssText = `
                    position: absolute;
                    width: 2px;
                    height: 2px;
                    background: var(--neuro-blue);
                    border-radius: 50%;
                    opacity: 0.1;
                    animation: float ${Math.random() * 3 + 2}s ease-in-out infinite alternate;
                    left: ${Math.random() * 100}%;
                    top: ${Math.random() * 100}%;
                `;
                document.querySelector('.neuronal-background').appendChild(particle);
            }

        // Efecto de carga en el botón submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitBtn = document.querySelector('input[type="submit"]');
            submitBtn.value = 'Iniciando sesión...';
            submitBtn.style.opacity = '0.8';
        });

        const alertContainer = document.querySelector('.alert-container');
        const alert = alertContainer.querySelector('.alert');
        
        if (alert) {
            // Mostrar el contenedor si hay alerta
            alertContainer.style.display = 'block';
            
            // Ocultar automáticamente después de 2 segundos
            setTimeout(() => {
                if (alert) {
                    alert.style.animation = 'fadeOut 0.5s forwards';
                    setTimeout(() => {
                        alert.remove();
                        alertContainer.style.display = 'none';
                    }, 500);
                }
            }, 2000);
        } else {
            // Ocultar el contenedor si no hay alerta
            alertContainer.style.display = 'none';
        }
    </script>
</body>
</html>