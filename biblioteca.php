<?php
session_start();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca - Sinaptium</title>
    <link rel="icon" href="logo/cerebro.svg" type="image/x-icon">
    <link href="estilos_bo/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">
    <link href="css/biblioteca.css" rel="stylesheet">
</head>
<body>
    <div class="neuronal-background"></div>

    <?php include 'componentes/navbar.php'; ?>

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
                
                <div class="category-tags">
                    <div class="category-tag active" data-category="all">Todos</div>
                    <div class="category-tag" data-category="literatura">Literatura</div>
                    <div class="category-tag" data-category="autoayuda">Autoayuda</div>
                    <div class="category-tag" data-category="ciencia">Ciencia</div>
                    <div class="category-tag" data-category="filosofia">Filosofía</div>
                    <div class="category-tag" data-category="historia">Historia</div>
                </div>

                <div class="book-grid" id="bookGrid">
                    <!-- Libro 1 -->
                    <div class="book-card" data-aos="fade-up" data-category="historia">
                        <div class="book-cover">
                            <img src="https://images.cdn1.buscalibre.com/fit-in/360x360/3d/db/3ddb14b13cce492d5132e2db8d59bc10.jpg" alt="Portada Mi Lucha" class="img-fluid">
                        </div>
                        <div class="book-info">
                            <h5><a href="pdfs/Adolf-Hitler-Mi-lucha.pdf" target="_blank">Mi lucha</a></h5>
                            <p class="book-author">Adolf Hitler</p>
                            <span class="badge book-badge bg-purple">Historia</span>
                        </div>
                    </div>
                    <!-- Libro 2 -->
                    <div class="book-card" data-aos="fade-up" data-aos-delay="100" data-category="autoayuda">
                        <div class="book-cover">
                            <img src="https://images.cdn1.buscalibre.com/fit-in/360x360/eb/12/eb1208bccde8225d1a0dba04fdb682a4.jpg" alt="Portada Deja de ser tú" class="img-fluid">
                        </div>
                        <div class="book-info">
                            <h5><a href="pdfs/DEJA-DE-SER-TU-Joe-Dispenza.pdf" target="_blank">Deja de ser tú</a></h5>
                            <p class="book-author">Joe Dispenza</p>
                            <span class="badge book-badge bg-green">Autoayuda</span>
                        </div>
                    </div>
                    <!-- Libro 3 -->
                    <div class="book-card" data-aos="fade-up" data-aos-delay="200" data-category="ciencia">
                        <div class="book-cover">
                            <img src="https://images.cdn2.buscalibre.com/fit-in/360x360/44/cc/44ccb976e2fa52a7258f2ce22d580ee0.jpg" alt="Portada Desarrolle su cerebro" class="img-fluid">
                        </div>
                        <div class="book-info">
                            <h5><a href="pdfs/desarrolle-su-cerebro-joe-dispenza.pdf" target="_blank">Desarrolle su cerebro</a></h5>
                            <p class="book-author">Joe Dispenza</p>
                            <span class="badge book-badge bg-blue">Ciencia</span>
                        </div>
                    </div>
                    <!-- Libro 4 -->
                    <div class="book-card" data-aos="fade-up" data-aos-delay="300" data-category="literatura">
                        <div class="book-cover">
                            <img src="https://www.tornamesa.co/imagenes/9789588/978958888621.GIF" alt="Portada Cien años de soledad" class="img-fluid">
                        </div>
                        <div class="book-info">
                            <h5><a href="pdfs/GABRIEL GARCÍA MARQUEZ - Cien años de soledad.pdf" target="_blank">Cien años de soledad</a></h5>
                            <p class="book-author">Gabriel García Márquez</p>
                            <span class="badge book-badge bg-purple">Literatura</span>
                        </div>
                    </div>
                    <!-- Libro 5 -->
                    <div class="book-card" data-aos="fade-up" data-aos-delay="400" data-category="literatura">
                        <div class="book-cover">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSUnhwt279a27WrEttSQDrfOaUFWIegCpt1SQ&s" alt="Portada El amor en los tiempos del cólera" class="img-fluid">
                        </div>
                        <div class="book-info">
                            <h5><a href="pdfs/García Gabriel - El amor en los tiempos del cólera.pdf" target="_blank">El amor en los tiempos del cólera</a></h5>
                            <p class="book-author">Gabriel García Márquez</p>
                            <span class="badge book-badge bg-purple">Literatura</span>
                        </div>
                    </div>
                    <!-- Libro 6 -->
                    <div class="book-card" data-aos="fade-up" data-aos-delay="500" data-category="autoayuda">
                        <div class="book-cover">
                            <img src="https://www.matorral.com.co/imagenes/9786287/978628757836.webp" alt="Portada Hábitos Atómicos" class="img-fluid">
                        </div>
                        <div class="book-info">
                            <h5><a href="pdfs/HABITOS-ATOMICOS-JAMES-CLEAR.pdf" target="_blank">Hábitos atómicos</a></h5>
                            <p class="book-author">James Clear</p>
                            <span class="badge book-badge bg-green">Autoayuda</span>
                        </div>
                    </div>
                    <!-- Libro 7 -->
                    <div class="book-card" data-aos="fade-up" data-aos-delay="600" data-category="filosofia">
                        <div class="book-cover">
                            <img src="https://images.cdn2.buscalibre.com/fit-in/360x360/8e/85/8e85ebc532203c3b3b65fccea02690c2.jpg" alt="Portada Ética para Amador" class="img-fluid">
                        </div>
                        <div class="book-info">
                            <h5><a href="pdfs/Savater_etica_amador2.pdf" target="_blank">Ética para Amador</a></h5>
                            <p class="book-author">Fernando Savater</p>
                            <span class="badge book-badge bg-orange">Filosofía</span>
                        </div>
                    </div>
                    <!-- Libro 8 -->
                    <div class="book-card" data-aos="fade-up" data-aos-delay="700" data-category="literatura">
                        <div class="book-cover">
                            <img src="https://img.perlego.com/book-covers/2787451/9788418211355.jpg" alt="Portada Crimen y Castigo" class="img-fluid">
                        </div>
                        <div class="book-info">
                            <h5><a href="pdfs/Fiodor Dostoyevski Crimen y castigo.pdf" target="_blank">Crimen y Castigo</a></h5>
                            <p class="book-author">Fiódor Dostoyevski</p>
                            <span class="badge book-badge bg-purple">Literatura</span>
                        </div>
                    </div>
                    <!-- Libro 9 -->
                    <div class="book-card" data-aos="fade-up" data-aos-delay="800" data-category="literatura">
                        <div class="book-cover">
                            <img src="https://proassets.planetadelibros.com.co/usuaris/libros/thumbs/a3eebb0c-7d4f-4101-b037-456eb68ea2b3/d_1200_1200/348828_portada_don-quijote-de-la-mancha_geronimo-stilton_202201241648.webp" alt="Portada Don Quijote" class="img-fluid">
                        </div>
                        <div class="book-info">
                            <h5><a href="pdfs/quijote.pdf" target="_blank">Don Quijote de la Mancha</a></h5>
                            <p class="book-author">Miguel de Cervantes</p>
                            <span class="badge book-badge bg-purple">Literatura</span>
                        </div>
                    </div>
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
                        <li class="mb-2"><a href="index.php" class="footer-link">Inicio</a></li>
                        <li class="mb-2"><a href="nosotros.php" class="footer-link">Nosotros</a></li>
                        <li class="mb-2"><a href="funcionamiento.php" class="footer-link">¿Cómo funciona?</a></li>
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

    <script src="estilos_bo/js/bootstrap.bundle.min.js"></script>
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