<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';
include_once HOME_PATH . 'cx/peticiones.php';

$query = "SELECT b.*, a.nombre as autor_nombre, a.apellido as autor_apellido, c.nombre as categoria_nombre 
            FROM biblioteca b 
            LEFT JOIN autores a ON b.autor_id = a.id 
            LEFT JOIN categorias c ON b.categoria_id = c.id 
            ORDER BY b.titulo";

$libros = peticionSQL($query, [], true);
$usuarioLogueado = isset($_SESSION['usuario_id']);

if (isset($libros['error'])) {
    $libros = [];
}

include_once HOME_PATH . 'componentes/head_component.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php renderHead('Biblioteca - Sinaptium'); ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/estilos.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/biblioteca.css" >
</head>
<body>
    <div class="neuronal-background"></div>
    <?php include HOME_PATH . 'componentes/navbar.php'; ?>

    <header class="hero-biblioteca">
        <div class="container text-center">
            <h1 data-aos="fade-up">Biblioteca de Sinaptium</h1>
            <p class="lead" data-aos="fade-up" data-aos-delay="100">Descubre conocimiento ilimitado a través de nuestros recursos</p>
        </div>
    </header>
    <section class="section-padding">
        <div class="container">
            <div class="content-card" data-aos="fade-up">
                <h2 class="text-center mb-4 purple">Explora Nuestra Colección</h2>
                
                <div class="search-container">
                    <input type="text" id="searchBooks" placeholder="Buscar libros por título o autor..." class="search-input">
                </div>

                <div class="book-grid" id="bookGrid">
                    <?php if (empty($libros)): ?>
                        <div class="col-12 text-center">
                            <p>No hay libros disponibles en la biblioteca.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($libros as $libro): 
                            // Determinar la clase de badge según la categoría
                            $badgeClass = 'bg-secondary';
                            if (!empty($libro['categoria_nombre'])) {
                                switch(strtolower($libro['categoria_nombre'])) {
                                    case 'historia': $badgeClass = 'bg-purple'; break;
                                    case 'autoayuda': $badgeClass = 'bg-green'; break;
                                    case 'ciencia': $badgeClass = 'bg-blue'; break;
                                    case 'filosofía': $badgeClass = 'bg-orange'; break;
                                    case 'literatura': $badgeClass = 'bg-purple'; break;
                                    default: $badgeClass = 'bg-secondary';
                                }
                            }
                            
                            // Usar la imagen del libro o una por defecto
                            $imagen = !empty($libro['imagen']) ? $libro['imagen'] : 'https://placehold.co/600x400?text=Sin+Imagen';
                            
                            // Determinar el enlace (priorizar archivo PDF si existe)
                            $enlace = !empty($libro['archivo_pdf']) ? $libro['archivo_pdf'] : $libro['enlace'];
                        ?>
                            <div class="book-card" data-category="<?php echo strtolower($libro['categoria_nombre'] ?? ''); ?>">
                                <div class="book-cover">
                                    <img src="<?php echo htmlspecialchars($imagen); ?>" alt="Portada de <?php echo htmlspecialchars($libro['titulo']); ?>" class="img-fluid">
                                </div>
                                <div class="book-info">
                                    <h5>
                                        <?php if (!empty($enlace)): ?>
                                            <a href="<?php echo htmlspecialchars($enlace); ?>" target="_blank">
                                                <?php echo htmlspecialchars($libro['titulo']); ?>
                                            </a>
                                        <?php else: ?>
                                            <?php echo htmlspecialchars($libro['titulo']); ?>
                                        <?php endif; ?>
                                    </h5>
                                    <p class="book-author">
                                        <?php if (!empty($libro['autor_nombre'])): ?>
                                            <?php echo htmlspecialchars($libro['autor_nombre'] . ' ' . $libro['autor_apellido']); ?>
                                        <?php else: ?>
                                            <span class="text-muted">Autor desconocido</span>
                                        <?php endif; ?>
                                    </p>
                                    <?php if (!empty($libro['categoria_nombre'])): ?>
                                        <span class="badge book-badge <?php echo $badgeClass; ?>">
                                            <?php echo htmlspecialchars($libro['categoria_nombre']); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>    
        </div>
    </section>
    <footer class="biblioteca-footer py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="blue">Sinaptium</h5>
                    <p class="footer-text">Expandiendo mentes a través del conocimiento.</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="blue">Enlaces rápidos</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?php echo BASE_URL; ?>" class="footer-link">Inicio</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL; ?>nosotros.php" class="footer-link">Nosotros</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL; ?>funcionamiento.php" class="footer-link">¿Cómo funciona?</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="blue">Contacto</h5>
                    <p class="footer-text">contacto@sinaptium.com</p>
                </div>
            </div>
            <hr class="footer-divider">
            <p class="footer-text text-center mb-0">© 2025 Sinaptium. Todos los derechos reservados.</p>
        </div>
    </footer>
    <script src="<?php echo BASE_URL; ?>estilos_bo/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            offset: 50,
            once: true
        });

        // Funcionalidad de búsqueda
        document.getElementById('searchBooks').addEventListener('input', function() {
            let searchTerm = this.value.toLowerCase();
            let bookCards = document.querySelectorAll('.book-card');
            
            bookCards.forEach(function(card) {
                let title = card.querySelector('h5 a').textContent.toLowerCase();
                let author = card.querySelector('.book-author').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || author.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Funcionalidad de categorías
        document.querySelectorAll('.category-tag').forEach(function(tag) {
            tag.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                
                document.querySelectorAll('.category-tag').forEach(function(t) {
                    t.classList.remove('active');
                });
                
                this.classList.add('active');
                
                document.querySelectorAll('.book-card').forEach(function(card) {
                    if (category === 'all' || card.getAttribute('data-category') === category) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Precarga de imágenes
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.book-cover img');
            images.forEach(img => {
                if (img.complete) {
                    img.classList.add('loaded');
                } else {
                    img.addEventListener('load', function() {
                        this.classList.add('loaded');
                    });
                    img.addEventListener('error', function() {
                        this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjMzMzIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxOCIgZmlsbD0iI2ZmZiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlbiBubyBlbmNvbnRyYWRhPC90ZXh0Pjwvc3ZnPg==';
                        this.classList.add('loaded');
                    });
                }
            });
        });
    </script>
</body>
</html>