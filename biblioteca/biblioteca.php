<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Determinar si el usuario está logueado
$usuarioLogueado = isset($_SESSION['usuario_id']);

// Si el usuario no está logueado, mostrar vista de lectura
if (!$usuarioLogueado) {
    // Obtener todos los libros con información de autores y categorías
    include_once HOME_PATH . 'cx/peticiones.php';
    $query = "SELECT b.*, a.nombre as autor_nombre, a.apellido as autor_apellido, c.nombre as categoria_nombre 
              FROM biblioteca b 
              LEFT JOIN autores a ON b.autor_id = a.id 
              LEFT JOIN categorias c ON b.categoria_id = c.id 
              ORDER BY b.titulo";
    $libros = peticionSQL($query, [], true);
    
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
                            <li class="mb-2"><a href="/" class="footer-link">Inicio</a></li>
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
    <?php
    exit; // Terminar la ejecución para usuarios no logueados
}

// Si el usuario está logueado, mostrar la vista completa de administración
include_once HOME_PATH . 'cx/peticiones.php';

// Mostrar mensajes si existen
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    echo "<div class='alert alert-{$mensaje['tipo']} alert-dismissible fade show' role='alert'>
            {$mensaje['texto']}
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
    unset($_SESSION['mensaje']);
}

// Obtener todos los libros con información de autores y categorías
$query = "SELECT b.*, a.nombre as autor_nombre, a.apellido as autor_apellido, c.nombre as categoria_nombre 
          FROM biblioteca b 
          LEFT JOIN autores a ON b.autor_id = a.id 
          LEFT JOIN categorias c ON b.categoria_id = c.id 
          ORDER BY b.titulo";
$libros = peticionSQL($query, [], true);

// Si hay error, mostrarlo
if (isset($libros['error'])) {
    echo '<div class="alert alert-danger">Error: ' . $libros['error'] . '</div>';
    $libros = [];
}

// Obtener todos los autores y categorías para usar en el modal
$autores = listarRegistros('autores');
if (isset($autores['error'])) {
    $autores = [];
}

$categorias = listarRegistros('categorias');
if (isset($categorias['error'])) {
    $categorias = [];
}

include_once HOME_PATH . 'componentes/head_component.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php renderHead('Biblioteca'); ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/dashboard.css">
</head>
<body>
<!-- Resto del código de administración (tu código original) -->
<!-- Biblioteca Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Lista de Libros</span>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalLibro" data-mode="create">
            <i class="fas fa-plus me-1"></i> Nuevo Libro
        </button>
    </div>
    <div class="card-body">
        <?php if (empty($libros)): ?>
            <div class="alert alert-info">
                No hay libros registrados en la biblioteca.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Categoría</th>
                            <th>Enlace</th>
                            <th>Archivo</th>
                            <th>Fecha Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($libros as $libro): ?>
                            <tr>
                                <td><?php echo $libro['id']; ?></td>
                                <td><?php echo htmlspecialchars($libro['titulo']); ?></td>
                                <td>
                                    <?php if (!empty($libro['autor_nombre'])): ?>
                                        <?php echo htmlspecialchars($libro['autor_nombre'] . ' ' . $libro['autor_apellido']); ?>
                                    <?php else: ?>
                                        <span class="text-muted">Sin autor</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($libro['categoria_nombre'])): ?>
                                        <span class="badge bg-info"><?php echo htmlspecialchars($libro['categoria_nombre']); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Sin categoría</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo htmlspecialchars($libro['enlace']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-external-link-alt"></i> Ver
                                    </a>
                                </td>
                                <td>
                                    <?php if (!empty($libro['archivo_pdf'])): ?>
                                        <a href="<?php echo htmlspecialchars($libro['archivo_pdf']); ?>" target="_blank" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-file-pdf"></i> PDF
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Sin archivo</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($libro['fecha_creacion'])); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary action-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalLibro"
                                            data-mode="edit"
                                            data-id="<?php echo $libro['id']; ?>"
                                            data-titulo="<?php echo htmlspecialchars($libro['titulo']); ?>"
                                            data-enlace="<?php echo htmlspecialchars($libro['enlace']); ?>"
                                            data-imagen="<?php echo htmlspecialchars($libro['imagen'] ?? ''); ?>"
                                            data-archivo_pdf="<?php echo htmlspecialchars($libro['archivo_pdf'] ?? ''); ?>"
                                            data-autor_id="<?php echo $libro['autor_id']; ?>"
                                            data-categoria_id="<?php echo $libro['categoria_id']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger action-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEliminarLibro"
                                            data-id="<?php echo $libro['id']; ?>"
                                            data-titulo="<?php echo htmlspecialchars($libro['titulo']); ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal único para Crear/Editar Libro -->
<div class="modal fade" id="modalLibro" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLibroTitle">Crear Nuevo Libro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo BASE_URL; ?>biblioteca/guardar_libro.php" method="POST" id="formLibro" enctype="multipart/form-data">
                <input type="hidden" id="libroId" name="id">
                <input type="hidden" id="formMode" name="mode" value="create">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="inputTitulo" class="form-label">Título del Libro</label>
                                <input type="text" class="form-control" id="inputTitulo" name="titulo" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="selectCategoria" class="form-label">Categoría</label>
                                <select class="form-select" id="selectCategoria" name="categoria_id">
                                    <option value="">Seleccionar categoría</option>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?php echo $categoria['id']; ?>"><?php echo htmlspecialchars($categoria['nombre']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="selectAutor" class="form-label">Autor</label>
                                <select class="form-select" id="selectAutor" name="autor_id" onchange="toggleAutorInput()">
                                    <option value="">Seleccionar autor</option>
                                    <?php foreach ($autores as $autor): ?>
                                        <option value="<?php echo $autor['id']; ?>">
                                            <?php echo htmlspecialchars($autor['nombre'] . ' ' . $autor['apellido']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                    <option value="otro">Otro (especificar nombre)</option>
                                </select>
                                
                                <div id="nuevoAutorContainer" class="mt-2" style="display: none;">
                                    <input type="text" class="form-control" id="nuevoAutorNombre" name="nuevo_autor_nombre" placeholder="Nombre del autor">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inputEnlace" class="form-label">Enlace (opcional si sube PDF)</label>
                                <input type="url" class="form-control" id="inputEnlace" name="enlace" placeholder="https://...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inputImagen" class="form-label">URL de Imagen (opcional)</label>
                                <input type="url" class="form-control" id="inputImagen" name="imagen" placeholder="https://...">
                                <div class="form-text">Si no se especifica, se usará una imagen por defecto</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inputArchivo" class="form-label">Subir Archivo PDF (opcional)</label>
                                <input type="file" class="form-control" id="inputArchivo" name="archivo_pdf" accept=".pdf">
                                <div class="form-text">Tamaño máximo: 10MB</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="submitButton">Crear Libro</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Eliminar Libro -->
<div class="modal fade" id="modalEliminarLibro" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Libro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label='Close'></button>
            </div>

            <form action="<?php echo BASE_URL; ?>biblioteca/eliminar_libro.php" method="POST">
                <input type="hidden" id="eliminarId" name="id">
                <div class="modal-body">
                    <p>¿Está seguro que desea eliminar el libro <strong id="libroEliminar"></strong>?</p>
                    <p class="text-danger">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar Libro</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script para manejar los modales -->
<script>
    function toggleAutorInput() {
        const selectAutor = document.getElementById('selectAutor');
        const nuevoAutorContainer = document.getElementById('nuevoAutorContainer');
        
        if (selectAutor.value === 'otro') {
            nuevoAutorContainer.style.display = 'block';
        } else {
            nuevoAutorContainer.style.display = 'none';
        }
    }
document.addEventListener('DOMContentLoaded', function() {
    // Modal único para crear/editar
    const modalLibro = document.getElementById('modalLibro');
    if (modalLibro) {
        modalLibro.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const mode = button.getAttribute('data-mode');
            const form = document.getElementById('formLibro');
            const title = document.getElementById('modalLibroTitle');
            const submitButton = document.getElementById('submitButton');
            
            if (mode === 'edit') {
                // Modo edición
                const id = button.getAttribute('data-id');
                const titulo = button.getAttribute('data-titulo');
                const enlace = button.getAttribute('data-enlace');
                const archivo = document.getElementById('inputArchivo').files.length;
                const autor_id = button.getAttribute('data-autor_id');
                const categoria_id = button.getAttribute('data-categoria_id');
                const imagen = button.getAttribute('data-imagen') || '';
                
                document.getElementById('libroId').value = id;
                document.getElementById('inputTitulo').value = titulo;
                document.getElementById('inputEnlace').value = enlace;
                document.getElementById('selectAutor').value = autor_id;
                document.getElementById('selectCategoria').value = categoria_id;
                document.getElementById('formMode').value = 'edit';
                document.getElementById('inputImagen').value = imagen;
                
                // Cambiar textos
                title.textContent = 'Editar Libro';
                submitButton.textContent = 'Guardar Cambios';
            } else {
                // Modo creación
                document.getElementById('formMode').value = 'create';
                form.reset();
                document.getElementById('libroId').value = '';
                
                // Cambiar textos
                title.textContent = 'Crear Nuevo Libro';
                submitButton.textContent = 'Crear Libro';
            }
        });
    }
    
    // Modal de eliminación
    const modalEliminar = document.getElementById('modalEliminarLibro');
    if (modalEliminar) {
        modalEliminar.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const titulo = button.getAttribute('data-titulo');
            
            modalEliminar.querySelector('#eliminarId').value = id;
            modalEliminar.querySelector('#libroEliminar').textContent = titulo;
        });
    }

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
});
</script>
</body>
</html>