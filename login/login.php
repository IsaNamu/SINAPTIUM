<?php
// login.php - Agregar esto al principio del archivo, antes de <!doctype html>
session_start();

// Si el usuario ya está logueado, redirigirlo a la página principal
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: ../index.php");
    exit;
}
?>
<!doctype html>
<html lang="es">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sinaptium - Iniciar Sesión</title>
        <link href="../estilos_bo/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/estilos.css">
        <link rel="stylesheet" href="../css/login.css">
        <link rel="icon" href="../logo/cerebrso.svg" type="image/x-icon">
    </head>
<body>
    <div class="neuronal-background"></div>

    <!-- Navegación mínima -->
    <nav class="navbar-minimal">
        <div class="container">
            <a href="../index.php" class="back-home">
                <span>←</span> Volver al Inicio
            </a>
        </div>
    </nav>

    <!-- Contenedor del Login -->
    <div class="login-container">
        <div class="loginbox" data-aos="fade-up">
            <img src="../logo/logo.svg" class="avatar" alt="Sinaptium Logo">
            <h1>Iniciar Sesión</h1>
            
            <form method="POST" action="../login/controlador.php">
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
                <a href="../register/register.php">Crear cuenta nueva</a>
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
    </script>
</body>
</html>