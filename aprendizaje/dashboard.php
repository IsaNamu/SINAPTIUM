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

// Obtener todos los contenidos de materia_metodo_aprendizaje con información relacionada
$query = "SELECT mma.*, 
       m.nombre as materia_nombre,
       ma.nombre as metodo_aprendizaje_nombre,
       ma.descripcion as metodo_descripcion,
       (SELECT COUNT(*) 
        FROM materia_metodo_aprendizaje mma2 
        WHERE mma2.materia_id = mma.materia_id 
        AND mma2.metodo_aprendizaje_id = mma.metodo_aprendizaje_id 
        AND mma2.activo = TRUE) as total_contenidos
FROM materia_metodo_aprendizaje mma 
INNER JOIN materias m ON mma.materia_id = m.id 
INNER JOIN metodos_aprendizaje ma ON mma.metodo_aprendizaje_id = ma.id 
WHERE mma.activo = TRUE
ORDER BY m.nombre, ma.nombre, mma.fecha_creacion DESC";

$contenidos = peticionSQL($query, [], true);

// Obtener todas las materias y métodos de aprendizaje para usar en el modal
$materias = peticionSQL("SELECT id, nombre FROM materias ORDER BY nombre", [], true);
if (isset($materias['error'])) {
    $materias = [];
}

// Si hay error, mostrarlo
if (isset($contenidos['error'])) {
    echo '<div class="alert alert-danger">Error: ' . $contenidos['error'] . '</div>';
    $contenidos = [];
}

$metodosAprendizaje = peticionSQL("SELECT id, nombre FROM metodos_aprendizaje ORDER BY nombre", [], true);
if (isset($metodosAprendizaje['error'])) {
    $metodosAprendizaje = [];
}

// Tipos de archivo permitidos por método de aprendizaje
$tiposArchivo = [
    'audio' => 'Audio (MP3, WAV, etc.)',
    'video' => 'Video (MP4, AVI, etc.)',
    'documento' => 'Documento (PDF, DOC, etc.)',
    'imagen' => 'Imagen (JPG, PNG, etc.)',
    'interactivo' => 'Contenido Interactivo',
    'enlace' => 'Enlace Externo'
];

// Mapeo de métodos de aprendizaje a tipos permitidos para archivos
$restriccionesArchivos = [
    'kinestésico' => ['video', 'interactivo', 'enlace'], // No permite audio NI imagen
    'auditivo' => ['audio', 'documento', 'enlace'], // No permite imagen
    'visual' => ['imagen', 'video', 'documento', 'enlace'] // Permite imagen pero no audio
];

// Para facilitar el acceso, también crear un mapeo por ID
$restriccionesArchivosPorId = [];
foreach ($metodosAprendizaje as $metodo) {
    $nombreMetodo = strtolower($metodo['nombre']);
    $restriccionesArchivosPorId[$metodo['id']] = $restriccionesArchivos[$nombreMetodo] ?? ['documento', 'enlace'];
}

include_once HOME_PATH . 'componentes/head_component.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php renderHead('Gestión de Contenidos por Método de Aprendizaje'); ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/dashboard.css">
    <style>
        .badge-tipo {
            font-size: 0.8em;
            padding: 0.4em 0.6em;
        }
        .contenido-preview {
            max-height: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .archivo-icon {
            font-size: 1.2em;
            margin-right: 5px;
        }
        .tipo-bloqueado {
            opacity: 0.5;
            pointer-events: none;
        }
        .input-archivo-bloqueado {
            opacity: 0.6;
            pointer-events: none;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <!-- Contenidos Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Contenidos por Método de Aprendizaje</span>
            <div>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalContenido" data-mode="create">
                    <i class="fas fa-plus me-1"></i> Nuevo Contenido
                </button>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($contenidos)): ?>
                <div class="alert alert-info">
                    No hay contenidos registrados.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Materia</th>
                                <th>Método Aprendizaje</th>
                                <th>Tipo</th>
                                <th>Contenido</th>
                                <th>Recursos</th>
                                <th>Estado</th>
                                <th>Fecha Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contenidos as $contenido): ?>
                                <tr>
                                    <td><?php echo $contenido['id']; ?></td>
                                    <td>
                                        <span class="badge bg-primary"><?php echo htmlspecialchars($contenido['materia_nombre']); ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?php echo htmlspecialchars($contenido['metodo_aprendizaje_nombre']); ?></span>
                                    </td>
                                    <td>
                                        <?php 
                                        $tipo = $contenido['tipo'] ?? 'documento';
                                        $iconos = [
                                            'audio' => 'fas fa-music',
                                            'video' => 'fas fa-video',
                                            'documento' => 'fas fa-folder-open',
                                            'imagen' => 'fas fa-image',
                                            'interactivo' => 'fas fa-gamepad',
                                            'enlace' => 'fas fa-link'
                                        ];
                                        $colores = [
                                            'audio' => 'warning',
                                            'video' => 'danger',
                                            'documento' => 'primary',
                                            'imagen' => 'success',
                                            'interactivo' => 'info',
                                            'enlace' => 'secondary'
                                        ];
                                        ?>
                                        <span class="badge bg-<?php echo $colores[$tipo] ?? 'secondary'; ?> badge-tipo">
                                            <i class="<?php echo $iconos[$tipo] ?? 'fas fa-file'; ?> archivo-icon"></i>
                                            <?php echo ucfirst($tipo); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="contenido-preview" title="<?php echo htmlspecialchars($contenido['contenido']); ?>">
                                            <?php echo strlen($contenido['contenido']) > 100 ? 
                                                substr(htmlspecialchars($contenido['contenido']), 0, 100) . '...' : 
                                                htmlspecialchars($contenido['contenido']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (!empty($contenido['recursos'])): ?>
                                            <button class="btn btn-sm btn-outline-info" 
                                                    data-bs-toggle="popover" 
                                                    data-bs-title="Recursos" 
                                                    data-bs-content="<?php echo htmlspecialchars($contenido['recursos']); ?>">
                                                <i class="fas fa-eye"></i> Ver
                                            </button>
                                        <?php else: ?>
                                            <span class="text-muted">Sin recursos</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo $contenido['activo'] ? 'success' : 'secondary'; ?>">
                                            <?php echo $contenido['activo'] ? 'Activo' : 'Inactivo'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($contenido['fecha_creacion'])); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary action-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalContenido"
                                                data-mode="edit"
                                                data-id="<?php echo $contenido['id']; ?>"
                                                data-materia_id="<?php echo $contenido['materia_id']; ?>"
                                                data-titulo="<?php echo htmlspecialchars($contenido['titulo']); ?>"
                                                data-metodo_aprendizaje_id="<?php echo $contenido['metodo_aprendizaje_id']; ?>"
                                                data-contenido="<?php echo htmlspecialchars($contenido['contenido']); ?>"
                                                data-recursos="<?php echo htmlspecialchars($contenido['recursos'] ?? ''); ?>"
                                                data-img-representative="<?php echo htmlspecialchars($contenido['imagen'] ?? ''); ?>"
                                                data-tipo="<?php echo $contenido['tipo'] ?? 'documento'; ?>"
                                                data-activo="<?php echo $contenido['activo']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger action-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEliminarContenido"
                                                data-id="<?php echo $contenido['id']; ?>"
                                                data-materia="<?php echo htmlspecialchars($contenido['materia_nombre']); ?>"
                                                data-metodo="<?php echo htmlspecialchars($contenido['metodo_aprendizaje_nombre']); ?>">
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

<!-- Modal único para Crear/Editar Contenido -->
<div class="modal fade" id="modalContenido" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalContenidoTitle">Nuevo Contenido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo BASE_URL; ?>aprendizaje/guardar_aprendizaje.php" method="POST" id="formContenido" enctype="multipart/form-data">
                <input type="hidden" id="contenidoId" name="id">
                <input type="hidden" id="formMode" name="mode" value="create">
                <div class="modal-body">
                    <!-- Primera fila: Materia y Método de Aprendizaje -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="selectMateria" class="form-label">Materia *</label>
                            <select class="form-select" id="selectMateria" name="materia_id" required>
                                <option value="">Seleccionar materia</option>
                                <?php foreach ($materias as $materia): ?>
                                    <option value="<?php echo $materia['id']; ?>">
                                        <?php echo htmlspecialchars($materia['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="selectMetodoAprendizaje" class="form-label">Método de Aprendizaje *</label>
                            <select class="form-select" id="selectMetodoAprendizaje" name="metodo_aprendizaje_id" required>
                                <option value="">Seleccionar método</option>
                                <?php foreach ($metodosAprendizaje as $metodo): ?>
                                    <option value="<?php echo $metodo['id']; ?>" data-nombre="<?php echo htmlspecialchars(strtolower($metodo['nombre'])); ?>">
                                        <?php echo htmlspecialchars($metodo['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Segunda fila: Tipo de Contenido -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="selectTipo" class="form-label">Tipo de Contenido *</label>
                            <select class="form-select" id="selectTipo" name="tipo" required>
                                <option value="">Seleccionar tipo</option>
                                <?php foreach ($tiposArchivo as $valor => $texto): ?>
                                    <option value="<?php echo $valor; ?>"><?php echo $texto; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text" id="tipoRestriccionInfo"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="checkActivo" class="form-label">Estado</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="checkActivo" name="activo" value="1" checked>
                                <label class="form-check-label" for="checkActivo">Activo</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tercera fila: Contenido -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="inputTitulo" class="form-label">Título del Contenido *</label>
                            <input type="text" class="form-control" id="inputTitulo" name="titulo" required>
                        </div>
                        <div class="col-12">
                            <label for="textareaContenido" class="form-label">Contenido *</label>
                            <textarea class="form-control" id="textareaContenido" name="contenido" rows="4" 
                                      placeholder="Descripción del contenido, texto, instrucciones, etc." required></textarea>
                            <div class="form-text">Describe el contenido educativo para este método de aprendizaje.</div>
                        </div>
                    </div>
                    
                    <!-- Cuarta fila: Recursos -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="inputImagen" class="form-label">Imagen del contenido</label>
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
                            <label for="inputArchivoTexto" class="form-label">Recursos (URLs o archivos)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="inputArchivoTexto" name="archivo_pdf_url" placeholder="https://...">
                                <button type="button" class="btn btn-outline-secondary" title="Seleccionar recurso" onclick="seleccionarPDF()" id="btnSeleccionarPDF">
                                    <i class="fas fa-folder-open" aria-hidden="true"></i>
                                </button>
                                <input type="file" id="inputArchivo" name="archivo_pdf" style="display: none;" onchange="actualizarNombrePDF()">
                            </div>
                            <div class="form-text" id="archivoRestriccionInfo">Puedes incluir URLs de YouTube, Google Drive, archivos de audio, etc.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="submitButton">Guardar Contenido</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Eliminar Contenido -->
<div class="modal fade" id="modalEliminarContenido" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Contenido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label='Close'></button>
            </div>
            <form action="<?php echo BASE_URL; ?>aprendizaje/eliminar_aprendizaje.php" method="POST">
                <input type="hidden" id="eliminarId" name="id">
                <div class="modal-body">
                    <p>¿Está seguro que desea eliminar el contenido de <strong id="contenidoEliminarMateria"></strong> 
                    para el método <strong id="contenidoEliminarMetodo"></strong>?</p>
                    <p class="text-danger">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar Contenido</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script para manejar los modales -->
<script>
// Datos de restricciones por método de aprendizaje para archivos
const restriccionesArchivos = {
    'kinestésico': ['video', 'interactivo', 'enlace'], // No permite audio NI imagen
    'auditivo': ['audio', 'documento', 'enlace'], // No permite imagen
    'visual': ['imagen', 'video', 'documento', 'enlace'] // Permite imagen pero no audio
};

// Mapeo de tipos de archivo a extensiones aceptadas
const extensionesPorTipo = {
    'audio': '.mp3,.wav,.ogg,.m4a,.aac',
    'video': '.mp4,.avi,.mov,.wmv,.flv,.webm,.mkv',
    'documento': '.pdf,.doc,.docx,.txt,.ppt,.pptx,.xls,.xlsx',
    'imagen': '.jpg,.jpeg,.png,.gif,.bmp,.webp,.svg',
    'interactivo': '.html,.htm,.zip,.rar,.exe'
};

// Función para obtener las extensiones permitidas basado en el método
function obtenerExtensionesPermitidas(metodoNombre) {
    const tiposPermitidos = restriccionesArchivos[metodoNombre] || ['documento', 'enlace'];
    let extensiones = '';
    
    tiposPermitidos.forEach(tipo => {
        if (extensionesPorTipo[tipo]) {
            if (extensiones) extensiones += ',';
            extensiones += extensionesPorTipo[tipo];
        }
    });
    
    return extensiones;
}

// Función para actualizar las restricciones de archivos
function actualizarRestriccionesArchivos() {
    const selectMetodo = document.getElementById('selectMetodoAprendizaje');
    const inputArchivo = document.getElementById('inputArchivo');
    const btnSeleccionarPDF = document.getElementById('btnSeleccionarPDF');
    const inputArchivoTexto = document.getElementById('inputArchivoTexto');
    const archivoRestriccionInfo = document.getElementById('archivoRestriccionInfo');
    
    const metodoSeleccionado = selectMetodo.options[selectMetodo.selectedIndex];
    const nombreMetodo = metodoSeleccionado.getAttribute('data-nombre');
    
    if (nombreMetodo && restriccionesArchivos[nombreMetodo]) {
        const tiposPermitidos = restriccionesArchivos[nombreMetodo];
        const tiposNoPermitidos = Object.keys(extensionesPorTipo).filter(tipo => 
            !tiposPermitidos.includes(tipo)
        );
        
        // Actualizar el atributo accept del input file
        const extensionesPermitidas = obtenerExtensionesPermitidas(nombreMetodo);
        inputArchivo.accept = extensionesPermitidas;
        
        // Actualizar información de restricciones
        if (tiposNoPermitidos.length > 0) {
            const tiposNoPermitidosTexto = tiposNoPermitidos.map(tipo => {
                const nombres = {
                    'audio': 'archivos de audio',
                    'video': 'archivos de video', 
                    'imagen': 'imágenes',
                    'documento': 'documentos',
                    'interactivo': 'contenidos interactivos'
                };
                return nombres[tipo] || tipo;
            }).join(', ');
            
            archivoRestriccionInfo.innerHTML = `<small class="text-warning">No permitido para ${metodoSeleccionado.textContent}: ${tiposNoPermitidosTexto}</small>`;
            
            // Si hay un archivo seleccionado que no es permitido, limpiarlo
            if (inputArchivo.files.length > 0) {
                const fileName = inputArchivo.files[0].name.toLowerCase();
                const esPermitido = tiposPermitidos.some(tipo => {
                    const extPermitidas = extensionesPorTipo[tipo]?.split(',') || [];
                    return extPermitidas.some(ext => fileName.endsWith(ext.replace('.', '')));
                });
                
                if (!esPermitido) {
                    inputArchivo.value = '';
                    inputArchivoTexto.value = '';
                    alert(`El tipo de archivo seleccionado no está permitido para el método ${metodoSeleccionado.textContent}`);
                }
            }
        } else {
            archivoRestriccionInfo.innerHTML = '<small class="text-success">Todos los tipos de archivo permitidos</small>';
        }
    } else {
        inputArchivo.accept = '*';
        archivoRestriccionInfo.innerHTML = 'Puedes incluir URLs de YouTube, Google Drive, archivos de audio, etc.';
    }
}

// Función para actualizar los tipos de contenido permitidos
function actualizarTiposPermitidos() {
    const selectMetodo = document.getElementById('selectMetodoAprendizaje');
    const selectTipo = document.getElementById('selectTipo');
    const infoRestriccion = document.getElementById('tipoRestriccionInfo');
    
    const metodoSeleccionado = selectMetodo.options[selectMetodo.selectedIndex];
    const nombreMetodo = metodoSeleccionado.getAttribute('data-nombre');
    
    // Obtener tipos permitidos para este método
    const tiposPermitidos = restriccionesArchivos[nombreMetodo] || Object.keys(<?php echo json_encode($tiposArchivo); ?>);
    
    // Habilitar/deshabilitar opciones según las restricciones
    Array.from(selectTipo.options).forEach(option => {
        if (option.value === '') return; // No modificar la opción vacía
        
        if (tiposPermitidos.includes(option.value)) {
            option.disabled = false;
            option.classList.remove('tipo-bloqueado');
        } else {
            option.disabled = true;
            option.classList.add('tipo-bloqueado');
        }
    });
    
    // Actualizar información de restricciones
    if (nombreMetodo && restriccionesArchivos[nombreMetodo]) {
        const tiposNoPermitidos = Object.keys(<?php echo json_encode($tiposArchivo); ?>).filter(tipo => 
            !restriccionesArchivos[nombreMetodo].includes(tipo)
        );
        
        if (tiposNoPermitidos.length > 0) {
            infoRestriccion.innerHTML = `<small class="text-warning">No permitido para ${metodoSeleccionado.textContent}: ${tiposNoPermitidos.join(', ')}</small>`;
        } else {
            infoRestriccion.innerHTML = '<small class="text-success">Todos los tipos permitidos</small>';
        }
    } else {
        infoRestriccion.innerHTML = '';
    }
    
    // Si el tipo actualmente seleccionado no está permitido, resetearlo
    const tipoActual = selectTipo.value;
    if (tipoActual && !tiposPermitidos.includes(tipoActual)) {
        selectTipo.value = '';
    }
    
    // Actualizar también las restricciones de archivos
    actualizarRestriccionesArchivos();
}

document.addEventListener('DOMContentLoaded', function() {
    // Modal único para crear/editar
    const modalContenido = document.getElementById('modalContenido');
    if (modalContenido) {
        modalContenido.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const mode = button.getAttribute('data-mode');
            const form = document.getElementById('formContenido');
            const title = document.getElementById('modalContenidoTitle');
            const submitButton = document.getElementById('submitButton');
            
            if (mode === 'edit') {
                // Modo edición
                const id = button.getAttribute('data-id');
                const materia_id = button.getAttribute('data-materia_id');
                const metodo_aprendizaje_id = button.getAttribute('data-metodo_aprendizaje_id');
                const img_representative = button.getAttribute('data-img-representative');
                const contenido = button.getAttribute('data-contenido');
                const recursos = button.getAttribute('data-recursos');
                const tipo = button.getAttribute('data-tipo');
                const activo = button.getAttribute('data-activo');
                const titulo = button.getAttribute('data-titulo');
                
                // Llenar los campos del formulario
                document.getElementById('contenidoId').value = id;
                document.getElementById('selectMateria').value = materia_id;
                document.getElementById('selectMetodoAprendizaje').value = metodo_aprendizaje_id;
                document.getElementById('textareaContenido').value = contenido;
                document.getElementById('inputTitulo').value = titulo;
                document.getElementById('selectTipo').value = tipo;
                document.getElementById('checkActivo').checked = activo === '1';
                document.getElementById('formMode').value = 'edit';

                document.getElementById('inputArchivoTexto').value = recursos || '';
                document.getElementById('inputImagen').value = img_representative || '';
                
                // Actualizar restricciones basado en el método seleccionado
                actualizarTiposPermitidos();
                actualizarRestriccionesArchivos();
                
                // Cambiar textos
                title.textContent = 'Editar Contenido';
                submitButton.textContent = 'Guardar Cambios';
            } else {
                // Modo creación - resetear todo
                document.getElementById('formMode').value = 'create';
                form.reset();
                document.getElementById('contenidoId').value = '';
                document.getElementById('previewImagen').style.display = 'none';
                document.getElementById('tipoRestriccionInfo').innerHTML = '';
                document.getElementById('archivoRestriccionInfo').innerHTML = 'Puedes incluir URLs de YouTube, Google Drive, archivos de audio, etc.';
                
                // Cambiar textos
                title.textContent = 'Crear Nuevo Contenido';
                submitButton.textContent = 'Crear Contenido';
            }
        });
    }
    
    // Escuchar cambios en el selector de método de aprendizaje
    document.getElementById('selectMetodoAprendizaje').addEventListener('change', function() {
        actualizarTiposPermitidos();
        actualizarRestriccionesArchivos();
    });
    
    // Modal de eliminación
    const modalEliminar = document.getElementById('modalEliminarContenido');
    if (modalEliminar) {
        modalEliminar.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const materia = button.getAttribute('data-materia');
            const metodo = button.getAttribute('data-metodo');
            
            modalEliminar.querySelector('#eliminarId').value = id;
            modalEliminar.querySelector('#contenidoEliminarMateria').textContent = materia;
            modalEliminar.querySelector('#contenidoEliminarMetodo').textContent = metodo;
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
function actualizarNombrePDF() {
    const inputArchivo = document.getElementById('inputArchivo');
    const inputArchivoTexto = document.getElementById('inputArchivoTexto');
    
    if (inputArchivo.files.length > 0) {
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