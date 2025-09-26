<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';

// Si el usuario está logueado, mostrar la vista completa de administración
include_once HOME_PATH . 'cx/peticiones.php';
include_once HOME_PATH . 'verificar_sesion.php';

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
    <!-- Biblioteca Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Lista de Libros</span>
            <div>
                <a class="btn btn-secondary btn-sm" href="<?php echo BASE_URL; ?>biblioteca/biblioteca.php">
                    <i class="fas fa-book me-1"></i> Ver libros
                </a>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalLibro" data-mode="create">
                    <i class="fas fa-plus me-1"></i> Nuevo Libro
                </button>
            </div>
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
                    <!-- Primera fila: Título del libro (ocupa las 2 columnas) -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="inputTitulo" class="form-label">Título del Libro *</label>
                            <input type="text" class="form-control" id="inputTitulo" name="titulo" required>
                        </div>
                    </div>
                    
                    <!-- Segunda fila: Autor y Categoría (una columna cada uno) -->
                    <div class="row mb-3">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <label for="selectCategoria" class="form-label">Categoría</label>
                            <select class="form-select" id="selectCategoria" name="categoria_id">
                                <option value="">Seleccionar categoría</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?php echo $categoria['id']; ?>"><?php echo htmlspecialchars($categoria['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Tercera fila: Imagen y PDF (agrupados con iconos) -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="inputImagen" class="form-label">Imagen del Libro</label>
                            <div class="input-group">
                                <input type="url" class="form-control" id="inputImagen" name="imagen_url" placeholder="https://...">
                                <button type="button" class="btn btn-outline-secondary" title="Seleccionar imagen" onclick="seleccionarImagen()">
                                    <i class="fa fa-file-image" aria-hidden="true"></i>
                                </button>
                                <input type="file" id="fileImagen" name="imagen_archivo" accept="image/*" style="display: none;" onchange="procesarImagenSeleccionada()">
                            </div>
                            <div class="form-text">Puede usar URL o subir imagen. Tamaño máximo: 5MB</div>
                            
                            <!-- Previsualización de imagen automática -->
                            <div id="previewImagen" class="mt-2" style="display: none;">
                                <img src="" alt="Vista previa" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputArchivoTexto" class="form-label">Archivo PDF</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="inputArchivoTexto" name="archivo_pdf_url" placeholder="https://...">
                                <button type="button" class="btn btn-outline-secondary" title="Seleccionar pdf" onclick="seleccionarPDF()">
                                    <i class="fas fa-file-pdf" aria-hidden="true"></i>
                                </button>
                                <input type="file" id="inputArchivo" name="archivo_pdf" accept=".pdf" style="display: none;" onchange="actualizarNombrePDF()">
                            </div>
                            <div class="form-text">Tamaño máximo: 10MB. Puede usar URL o subir archivo.</div>
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
                const imagen = button.getAttribute('data-imagen') || '';
                const archivo_pdf = button.getAttribute('data-archivo_pdf') || '';
                const autor_id = button.getAttribute('data-autor_id');
                const categoria_id = button.getAttribute('data-categoria_id');
                
                // Llenar los campos del formulario
                document.getElementById('libroId').value = id;
                document.getElementById('inputTitulo').value = titulo;
                document.getElementById('selectAutor').value = autor_id;
                document.getElementById('selectCategoria').value = categoria_id;
                document.getElementById('formMode').value = 'edit';
                
                // Manejar la imagen - verificar si es una URL o está vacía
                if (imagen) {
                    document.getElementById('inputImagen').value = imagen;
                    // Mostrar previsualización de la imagen existente
                    const previewDiv = document.getElementById('previewImagen');
                    const previewImg = previewDiv.querySelector('img');
                    previewImg.src = imagen;
                    previewDiv.style.display = 'block';
                } else {
                    document.getElementById('inputImagen').value = '';
                    document.getElementById('previewImagen').style.display = 'none';
                }
                
                // Manejar el archivo PDF - mostrar la URL existente en el campo de texto
                if (archivo_pdf) {
                    // Extraer solo el nombre del archivo para mostrar
                    const pdfFileName = archivo_pdf.split('/').pop();
                    document.getElementById('inputArchivoTexto').value = pdfFileName;
                    // También puedes mostrar la URL completa si prefieres:
                    // document.getElementById('inputArchivoTexto').value = archivo_pdf;
                } else {
                    document.getElementById('inputArchivoTexto').value = '';
                }
                
                // Limpiar file inputs al editar (para evitar conflictos)
                document.getElementById('fileImagen').value = '';
                document.getElementById('inputArchivo').value = '';
                
                // Cambiar textos
                title.textContent = 'Editar Libro';
                submitButton.textContent = 'Guardar Cambios';
            } else {
                // Modo creación - resetear todo
                document.getElementById('formMode').value = 'create';
                form.reset();
                document.getElementById('libroId').value = '';
                document.getElementById('previewImagen').style.display = 'none';
                
                // Cambiar textos
                title.textContent = 'Crear Nuevo Libro';
                submitButton.textContent = 'Crear Libro';
            }
            
            // Asegurarse de que el contenedor de autor se muestre/oculte correctamente
            toggleAutorInput();
        });
    }
    
    // El resto de tu código permanece igual...
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

    // Previsualización automática de imagen al escribir URL
    document.getElementById('inputImagen').addEventListener('input', function() {
        const imagenUrl = this.value;
        const previewDiv = document.getElementById('previewImagen');
        const previewImg = previewDiv.querySelector('img');
        const fileInput = document.getElementById('fileImagen');
        
        if (imagenUrl) {
            previewImg.src = imagenUrl;
            previewDiv.style.display = 'block';
            
            // Limpiar el file input cuando se escribe una URL
            fileInput.value = '';
            
            // Manejar error de carga de imagen
            previewImg.onerror = function() {
                previewDiv.innerHTML = '<div class="alert alert-warning p-2">No se puede cargar la imagen</div>';
            };
            
            previewImg.onload = function() {
                previewDiv.style.display = 'block';
            };
        } else {
            previewDiv.style.display = 'none';
        }
    });

    const alertContainer = document.querySelector('.alert-container');
    const alert = alertContainer?.querySelector('.alert');
    
    if (alert && alertContainer) {
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
    } else if (alertContainer) {
        // Ocultar el contenedor si no hay alerta
        alertContainer.style.display = 'none';
    }
});

// Mover las funciones fuera del DOMContentLoaded para que sean globales
function toggleAutorInput() {
    const selectAutor = document.getElementById('selectAutor');
    const nuevoAutorContainer = document.getElementById('nuevoAutorContainer');
    nuevoAutorContainer.style.display = selectAutor.value === 'otro' ? 'block' : 'none';
}

function actualizarNombrePDF() {
    const inputArchivo = document.getElementById('inputArchivo');
    const inputArchivoTexto = document.getElementById('inputArchivoTexto');
    
    if (inputArchivo.files.length > 0) {
        // Cuando se selecciona un archivo, limpiar la URL
        inputArchivoTexto.value = inputArchivo.files[0].name;
    }
}

function procesarImagenSeleccionada() {
    const fileInput = document.getElementById('fileImagen');
    const urlInput = document.getElementById('inputImagen');
    const previewContainer = document.getElementById('previewImagen');
    const previewImage = previewContainer.querySelector('img');
    
    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.style.display = 'block';
            
            // Limpiar el campo de URL cuando se selecciona un archivo
            urlInput.value = '';
        }
        reader.readAsDataURL(fileInput.files[0]);
    } else {
        previewImage.src = '';
        previewContainer.style.display = 'none';
    }
}

function seleccionarPDF() {
    document.getElementById('inputArchivo').click();
}

function seleccionarImagen() {
    document.getElementById('fileImagen').click();
}
</script>
</body>
</html>