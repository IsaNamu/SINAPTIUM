<?php
// Al inicio del archivo register.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
}

if (!defined('HOME_PATH')) {
    define('HOME_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');
}

$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : '';
unset($_SESSION['mensaje']); // Limpiar el mensaje después de mostrarlo
include_once HOME_PATH . 'componentes/head_component.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php renderHead('Sinaptium - Registro'); ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/register.css">
</head>
<body>
    <div class="neuronal-background"></div>

    <!-- Navegación mínima -->
    <nav class="navbar-minimal">
        <div class="container">
            <a href="../login/login.php" class="back-home">
                <span>←</span> Volver al login
            </a>
        </div>
    </nav>

    <!-- Contenedor del Registro -->
    <div class="register-container">
        <div class="registerbox" data-aos="fade-up">
            <img src="../logo/logo.svg" class="avatar" alt="Sinaptium Logo" style="display: block; margin: 0 auto 20px; max-width: 120px;">
            <div class="alert-container">
                <?php
                if (!empty($mensaje)) {
                    echo $mensaje;
                }
                ?>
            </div>
            <h1>Crear Cuenta</h1>
            
            <form method="POST" action="../register/controlador.php">
                <div class="input-wrapper">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" placeholder="Ingrese su usuario" required>
                </div>
                
                <div class="input-wrapper">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" placeholder="Ingrese su correo electrónico" required>
                </div>
                
                <div class="input-wrapper">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Ingrese su contraseña" required>
                </div>
                
                <div class="input-wrapper">
                    <label for="confirm_password">Confirmar Contraseña</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirme su contraseña" required>
                </div>
                
                <input type="submit" value="Registrarse">
            </form>

            <div class="login-link">
                <p>¿Ya tienes una cuenta?</p>
                <a href="../login/login.php">Iniciar Sesión</a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../estilos_bo/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    
    <script>
        // Inicializar AOS
        AOS.init({
            duration: 800,
            offset: 50,
        });

        // Efectos visuales adicionales
        document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Crear partículas de fondo
        for (let i = 0; i < 30; i++) {
            const particle = document.createElement('div');
            particle.style.cssText = `
                position: absolute;
                width: 2px;
                height: 2px;
                background: var(--neuro-blue, #3b82f6);
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
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                
                // Crear y mostrar el mensaje de error en el alert-container
                const alertContainer = document.querySelector('.alert-container');
                alertContainer.innerHTML = '<div class="alert alert-danger">Las contraseñas no coinciden</div>';
                alertContainer.style.display = 'block';
                
                // Animación para que desaparezca después de 5 segundos
                setTimeout(() => {
                    const alert = alertContainer.querySelector('.alert');
                    if (alert) {
                        alert.style.animation = 'fadeOut 0.5s forwards';
                        setTimeout(() => {
                            alert.remove();
                            alertContainer.style.display = 'none';
                        }, 500);
                    }
                }, 2000);
                
                return;
            }
            
            const submitBtn = document.querySelector('input[type="submit"]');
            submitBtn.value = 'Creando cuenta...';
            submitBtn.style.opacity = '0.8';
        });
    </script>
</body>
</html>