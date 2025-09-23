<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';
include_once HOME_PATH . 'componentes/head_component.php';
?>
<!doctype html>
<html lang="es">
<head>
    <?php renderHead('Sinaptium - Reconocimientos'); ?>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="neuronal-background"></div>

   <?php include '../componentes/navbar.php'; ?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reconocimiento Docente - Sinaptium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/reco.css">
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="neuronal-background"></div>

    <!-- Hero Section -->
    <section class="hero-recognition">
        <div class="container">
            <h1><i class="fas fa-award"></i> Reconocimiento Docente</h1>
            <p>Celebramos la excelencia académica y el compromiso educativo de nuestros destacados profesores</p>
        </div>
    </section>

    <!-- Teacher Recognition Section - Hugo V-->
    <section class="section-padding">
        <div class="container">
            <div class="teacher-card">
                <div class="floating-elements">
                    <div class="floating-icon"><i class="fas fa-star"></i></div>
                    <div class="floating-icon"><i class="fas fa-brain"></i></div>
                    <div class="floating-icon"><i class="fas fa-trophy"></i></div>
                </div>

                <div class="teacher-header text-center">
                    <svg class="teacher-photo" viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="faceGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#4fc3f7;stop-opacity:0.3" />
                                <stop offset="100%" style="stop-color:#9c27b0;stop-opacity:0.3" />
                            </linearGradient>
                        </defs>
                        <circle cx="75" cy="75" r="75" fill="url(#faceGradient)" stroke="#9c27b0" stroke-width="4"/>
                        <circle cx="75" cy="60" r="35" fill="#4fc3f7" opacity="0.8"/>
                        <circle cx="65" cy="55" r="3" fill="white"/>
                        <circle cx="85" cy="55" r="3" fill="white"/>
                        <path d="M 65 70 Q 75 80 85 70" stroke="white" stroke-width="2" fill="none"/>
                        <rect x="60" y="35" width="30" height="15" rx="7" fill="#9c27b0" opacity="0.6"/>
                        <text x="75" y="120" text-anchor="middle" fill="white" font-size="12" font-family="Space Grotesk">👨‍🏫</text>
                    </svg>
                    
                    <h2 class="teacher-name">Hugo Marino Perez Vahos</h2>
                    <p class="teacher-title">Profesor Titular de Neurociencias Cognitivas</p>
                    <div class="recognition-badge">
                        <i class="fas fa-medal"></i> Docente del Año en: Física, Química y Bilogía en este 2025
                    </div>
                </div>

                <div class="teacher-content">
                    <!-- Biografía -->
                    <div class="biography-section">
                        <h3 class="section-title">
                            <i class="fas fa-user-graduate"></i>
                            Biografía
                        </h3>
                        <p class="biography-text">
                            El Dr. Carlos Mendoza Rivera es un destacado neurocientífico con más de 15 años de experiencia en investigación y docencia. Graduado con honores de la Universidad Nacional, obtuvo su doctorado en Neurociencias Cognitivas en la Universidad de Barcelona. Su pasión por la enseñanza y la investigación lo ha convertido en una figura inspiradora para cientos de estudiantes.
                        </p>
                        <p class="biography-text">
                            Especializado en plasticidad neuronal y aprendizaje, ha dedicado su carrera a entender cómo el cerebro procesa y almacena información, aplicando estos conocimientos para mejorar las metodologías educativas en el aula.
                        </p>
                    </div>

                    <!-- Estadísticas -->
                    <div class="stats-container">
                        <div class="stat-item">
                            <span class="stat-number">15+</span>
                            <span class="stat-label">Años de Experiencia</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">Estudiantes Formados</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">25</span>
                            <span class="stat-label">Publicaciones</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">8</span>
                            <span class="stat-label">Premios Recibidos</span>
                        </div>
                    </div>

                    <!-- Logros y Contribuciones -->
                    <div class="biography-section">
                        <h3 class="section-title">
                            <i class="fas fa-trophy"></i>
                            Logros y Contribuciones
                        </h3>
                        <div class="achievements-grid">
                            <div class="achievement-item">
                                <div class="achievement-icon">📚</div>
                                <div class="achievement-title">Investigación Pionera</div>
                                <div class="achievement-description">
                                    Autor de 25 publicaciones en revistas indexadas sobre plasticidad neuronal y metodologías de aprendizaje innovadoras.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🧠</div>
                                <div class="achievement-title">Laboratorio de Neuroaprendizaje</div>
                                <div class="achievement-description">
                                    Fundador y director del Laboratorio de Neuroaprendizaje, donde se desarrollan técnicas educativas basadas en neurociencia.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🎓</div>
                                <div class="achievement-title">Formación de Nuevos Talentos</div>
                                <div class="achievement-description">
                                    Ha dirigido 12 tesis doctorales y 30 tesis de maestría, formando la próxima generación de neurocientíficos.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🌍</div>
                                <div class="achievement-title">Colaboración Internacional</div>
                                <div class="achievement-description">
                                    Colaborador activo en proyectos de investigación con universidades de España, Estados Unidos y Canadá.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">💡</div>
                                <div class="achievement-title">Innovación Educativa</div>
                                <div class="achievement-description">
                                    Desarrollador de la metodología "NeuroAprendizaje Activo", implementada en más de 20 instituciones educativas.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🏆</div>
                                <div class="achievement-title">Reconocimientos</div>
                                <div class="achievement-description">
                                    Ganador del Premio Nacional de Excelencia Docente 2023 y el Premio de Investigación en Neuroeducación 2022.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Razón del Reconocimiento -->
                    <div class="recognition-reason">
                        <h3 class="section-title">
                            <i class="fas fa-heart"></i>
                            ¿Por qué lo reconocemos?
                        </h3>
                        <p class="biography-text">
                            <strong>El Dr. Mendoza es reconocido por su excepcional dedicación a la excelencia educativa y su impacto transformador en la vida de sus estudiantes.</strong> Su enfoque innovador combina la investigación de vanguardia con una pedagogía centrada en el estudiante, creando experiencias de aprendizaje que van más allá del aula tradicional.
                        </p>
                        <p class="biography-text">
                            Sus estudiantes lo describen como un mentor inspirador que no solo transmite conocimiento, sino que despierta la curiosidad científica y el pensamiento crítico. Su metodología "NeuroAprendizaje Activo" ha revolucionado la forma en que se enseñan las neurociencias, haciendo que conceptos complejos sean accesibles y emocionantes.
                        </p>
                        <p class="biography-text">
                            <em>"El Dr. Mendoza no solo nos enseña sobre el cerebro, nos enseña a pensar con el cerebro. Su pasión es contagiosa y su compromiso con nuestro crecimiento académico y personal es incomparable."</em> - Testimonio de estudiante graduado.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <!-- Teacher Recognition Section - Carlos Bueno -->
    <section class="section-padding">
        <div class="container">
            <div class="teacher-card">
                <div class="floating-elements">
                    <div class="floating-icon"><i class="fas fa-star"></i></div>
                    <div class="floating-icon"><i class="fas fa-brain"></i></div>
                    <div class="floating-icon"><i class="fas fa-trophy"></i></div>
                </div>

                <div class="teacher-header text-center">
                    <svg class="teacher-photo" viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="faceGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#4fc3f7;stop-opacity:0.3" />
                                <stop offset="100%" style="stop-color:#9c27b0;stop-opacity:0.3" />
                            </linearGradient>
                        </defs>
                        <circle cx="75" cy="75" r="75" fill="url(#faceGradient)" stroke="#9c27b0" stroke-width="4"/>
                        <circle cx="75" cy="60" r="35" fill="#4fc3f7" opacity="0.8"/>
                        <circle cx="65" cy="55" r="3" fill="white"/>
                        <circle cx="85" cy="55" r="3" fill="white"/>
                        <path d="M 65 70 Q 75 80 85 70" stroke="white" stroke-width="2" fill="none"/>
                        <rect x="60" y="35" width="30" height="15" rx="7" fill="#9c27b0" opacity="0.6"/>
                        <text x="75" y="120" text-anchor="middle" fill="white" font-size="12" font-family="Space Grotesk">👨‍🏫</text>
                    </svg>
                    
                    <h2 class="teacher-name">Carlos Bueno</h2>
                    <p class="teacher-title">Profesor Titular de Neurociencias Cognitivas</p>
                    <div class="recognition-badge">
                        <i class="fas fa-medal"></i> Docente del Año en: Programación en el SENA, en este 2025
                    </div>
                </div>

                <div class="teacher-content">
                    <!-- Biografía -->
                    <div class="biography-section">
                        <h3 class="section-title">
                            <i class="fas fa-user-graduate"></i>
                            Biografía
                        </h3>
                        <p class="biography-text">
                            El Dr. Carlos Mendoza Rivera es un destacado neurocientífico con más de 15 años de experiencia en investigación y docencia. Graduado con honores de la Universidad Nacional, obtuvo su doctorado en Neurociencias Cognitivas en la Universidad de Barcelona. Su pasión por la enseñanza y la investigación lo ha convertido en una figura inspiradora para cientos de estudiantes.
                        </p>
                        <p class="biography-text">
                            Especializado en plasticidad neuronal y aprendizaje, ha dedicado su carrera a entender cómo el cerebro procesa y almacena información, aplicando estos conocimientos para mejorar las metodologías educativas en el aula.
                        </p>
                    </div>

                    <!-- Estadísticas -->
                    <div class="stats-container">
                        <div class="stat-item">
                            <span class="stat-number">15+</span>
                            <span class="stat-label">Años de Experiencia</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">Estudiantes Formados</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">25</span>
                            <span class="stat-label">Publicaciones</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">8</span>
                            <span class="stat-label">Premios Recibidos</span>
                        </div>
                    </div>

                    <!-- Logros y Contribuciones -->
                    <div class="biography-section">
                        <h3 class="section-title">
                            <i class="fas fa-trophy"></i>
                            Logros y Contribuciones
                        </h3>
                        <div class="achievements-grid">
                            <div class="achievement-item">
                                <div class="achievement-icon">📚</div>
                                <div class="achievement-title">Investigación Pionera</div>
                                <div class="achievement-description">
                                    Autor de 25 publicaciones en revistas indexadas sobre plasticidad neuronal y metodologías de aprendizaje innovadoras.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🧠</div>
                                <div class="achievement-title">Laboratorio de Neuroaprendizaje</div>
                                <div class="achievement-description">
                                    Fundador y director del Laboratorio de Neuroaprendizaje, donde se desarrollan técnicas educativas basadas en neurociencia.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🎓</div>
                                <div class="achievement-title">Formación de Nuevos Talentos</div>
                                <div class="achievement-description">
                                    Ha dirigido 12 tesis doctorales y 30 tesis de maestría, formando la próxima generación de neurocientíficos.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🌍</div>
                                <div class="achievement-title">Colaboración Internacional</div>
                                <div class="achievement-description">
                                    Colaborador activo en proyectos de investigación con universidades de España, Estados Unidos y Canadá.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">💡</div>
                                <div class="achievement-title">Innovación Educativa</div>
                                <div class="achievement-description">
                                    Desarrollador de la metodología "NeuroAprendizaje Activo", implementada en más de 20 instituciones educativas.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🏆</div>
                                <div class="achievement-title">Reconocimientos</div>
                                <div class="achievement-description">
                                    Ganador del Premio Nacional de Excelencia Docente 2023 y el Premio de Investigación en Neuroeducación 2022.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Razón del Reconocimiento -->
                    <div class="recognition-reason">
                        <h3 class="section-title">
                            <i class="fas fa-heart"></i>
                            ¿Por qué lo reconocemos?
                        </h3>
                        <p class="biography-text">
                            <strong>El Dr. Mendoza es reconocido por su excepcional dedicación a la excelencia educativa y su impacto transformador en la vida de sus estudiantes.</strong> Su enfoque innovador combina la investigación de vanguardia con una pedagogía centrada en el estudiante, creando experiencias de aprendizaje que van más allá del aula tradicional.
                        </p>
                        <p class="biography-text">
                            Sus estudiantes lo describen como un mentor inspirador que no solo transmite conocimiento, sino que despierta la curiosidad científica y el pensamiento crítico. Su metodología "NeuroAprendizaje Activo" ha revolucionado la forma en que se enseñan las neurociencias, haciendo que conceptos complejos sean accesibles y emocionantes.
                        </p>
                        <p class="biography-text">
                            <em>"El Dr. Mendoza no solo nos enseña sobre el cerebro, nos enseña a pensar con el cerebro. Su pasión es contagiosa y su compromiso con nuestro crecimiento académico y personal es incomparable."</em> - Testimonio de estudiante graduado.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    



    

    
    <!-- Teacher Recognition Section - Carlos Castillo -->
    <section class="section-padding">
        <div class="container">
            <div class="teacher-card">
                <div class="floating-elements">
                    <div class="floating-icon"><i class="fas fa-star"></i></div>
                    <div class="floating-icon"><i class="fas fa-brain"></i></div>
                    <div class="floating-icon"><i class="fas fa-trophy"></i></div>
                </div>

                <div class="teacher-header text-center">
                    <svg class="teacher-photo" viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="faceGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#4fc3f7;stop-opacity:0.3" />
                                <stop offset="100%" style="stop-color:#9c27b0;stop-opacity:0.3" />
                            </linearGradient>
                        </defs>
                        <circle cx="75" cy="75" r="75" fill="url(#faceGradient)" stroke="#9c27b0" stroke-width="4"/>
                        <circle cx="75" cy="60" r="35" fill="#4fc3f7" opacity="0.8"/>
                        <circle cx="65" cy="55" r="3" fill="white"/>
                        <circle cx="85" cy="55" r="3" fill="white"/>
                        <path d="M 65 70 Q 75 80 85 70" stroke="white" stroke-width="2" fill="none"/>
                        <rect x="60" y="35" width="30" height="15" rx="7" fill="#9c27b0" opacity="0.6"/>
                        <text x="75" y="120" text-anchor="middle" fill="white" font-size="12" font-family="Space Grotesk">👨‍🏫</text>
                    </svg>
                    
                    <h2 class="teacher-name">Carlos Castillo</h2>
                    <p class="teacher-title">Profesor Titular de Neurociencias Cognitivas</p>
                    <div class="recognition-badge">
                        <i class="fas fa-medal"></i> Docente del Año en: Educación Física en este 2025 
                    </div>
                </div>

                <div class="teacher-content">
                    <!-- Biografía -->
                    <div class="biography-section">
                        <h3 class="section-title">
                            <i class="fas fa-user-graduate"></i>
                            Biografía
                        </h3>
                        <p class="biography-text">
                            El Dr. Carlos Mendoza Rivera es un destacado neurocientífico con más de 15 años de experiencia en investigación y docencia. Graduado con honores de la Universidad Nacional, obtuvo su doctorado en Neurociencias Cognitivas en la Universidad de Barcelona. Su pasión por la enseñanza y la investigación lo ha convertido en una figura inspiradora para cientos de estudiantes.
                        </p>
                        <p class="biography-text">
                            Especializado en plasticidad neuronal y aprendizaje, ha dedicado su carrera a entender cómo el cerebro procesa y almacena información, aplicando estos conocimientos para mejorar las metodologías educativas en el aula.
                        </p>
                    </div>

                    <!-- Estadísticas -->
                    <div class="stats-container">
                        <div class="stat-item">
                            <span class="stat-number">15+</span>
                            <span class="stat-label">Años de Experiencia</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">Estudiantes Formados</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">25</span>
                            <span class="stat-label">Publicaciones</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">8</span>
                            <span class="stat-label">Premios Recibidos</span>
                        </div>
                    </div>

                    <!-- Logros y Contribuciones -->
                    <div class="biography-section">
                        <h3 class="section-title">
                            <i class="fas fa-trophy"></i>
                            Logros y Contribuciones
                        </h3>
                        <div class="achievements-grid">
                            <div class="achievement-item">
                                <div class="achievement-icon">📚</div>
                                <div class="achievement-title">Investigación Pionera</div>
                                <div class="achievement-description">
                                    Autor de 25 publicaciones en revistas indexadas sobre plasticidad neuronal y metodologías de aprendizaje innovadoras.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🧠</div>
                                <div class="achievement-title">Laboratorio de Neuroaprendizaje</div>
                                <div class="achievement-description">
                                    Fundador y director del Laboratorio de Neuroaprendizaje, donde se desarrollan técnicas educativas basadas en neurociencia.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🎓</div>
                                <div class="achievement-title">Formación de Nuevos Talentos</div>
                                <div class="achievement-description">
                                    Ha dirigido 12 tesis doctorales y 30 tesis de maestría, formando la próxima generación de neurocientíficos.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🌍</div>
                                <div class="achievement-title">Colaboración Internacional</div>
                                <div class="achievement-description">
                                    Colaborador activo en proyectos de investigación con universidades de España, Estados Unidos y Canadá.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">💡</div>
                                <div class="achievement-title">Innovación Educativa</div>
                                <div class="achievement-description">
                                    Desarrollador de la metodología "NeuroAprendizaje Activo", implementada en más de 20 instituciones educativas.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🏆</div>
                                <div class="achievement-title">Reconocimientos</div>
                                <div class="achievement-description">
                                    Ganador del Premio Nacional de Excelencia Docente 2023 y el Premio de Investigación en Neuroeducación 2022.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Razón del Reconocimiento -->
                    <div class="recognition-reason">
                        <h3 class="section-title">
                            <i class="fas fa-heart"></i>
                            ¿Por qué lo reconocemos?
                        </h3>
                        <p class="biography-text">
                            <strong>El Dr. Mendoza es reconocido por su excepcional dedicación a la excelencia educativa y su impacto transformador en la vida de sus estudiantes.</strong> Su enfoque innovador combina la investigación de vanguardia con una pedagogía centrada en el estudiante, creando experiencias de aprendizaje que van más allá del aula tradicional.
                        </p>
                        <p class="biography-text">
                            Sus estudiantes lo describen como un mentor inspirador que no solo transmite conocimiento, sino que despierta la curiosidad científica y el pensamiento crítico. Su metodología "NeuroAprendizaje Activo" ha revolucionado la forma en que se enseñan las neurociencias, haciendo que conceptos complejos sean accesibles y emocionantes.
                        </p>
                        <p class="biography-text">
                            <em>"El Dr. Mendoza no solo nos enseña sobre el cerebro, nos enseña a pensar con el cerebro. Su pasión es contagiosa y su compromiso con nuestro crecimiento académico y personal es incomparable."</em> - Testimonio de estudiante graduado.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>





    



    <!-- Teacher Recognition Section - Sindy Martinez -->
<section class="section-padding">
    <div class="container">
        <div class="teacher-card">
            <div class="floating-elements">
                <div class="floating-icon"><i class="fas fa-star"></i></div>
                <div class="floating-icon"><i class="fas fa-book-reader"></i></div>
                <div class="floating-icon"><i class="fas fa-hand-holding-heart"></i></div>
            </div>

            <div class="teacher-header text-center">
                <svg class="teacher-photo" viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="faceGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#4fc3f7;stop-opacity:0.3" />
                            <stop offset="100%" style="stop-color:#9c27b0;stop-opacity:0.3" />
                        </linearGradient>
                    </defs>
                    <circle cx="75" cy="75" r="75" fill="url(#faceGradient)" stroke="#9c27b0" stroke-width="4"/>
                    <circle cx="75" cy="60" r="35" fill="#4fc3f7" opacity="0.8"/>
                    <circle cx="65" cy="55" r="3" fill="white"/>
                    <circle cx="85" cy="55" r="3" fill="white"/>
                    <path d="M 65 70 Q 75 80 85 70" stroke="white" stroke-width="2" fill="none"/>
                    <rect x="60" y="35" width="30" height="15" rx="7" fill="#9c27b0" opacity="0.6"/>
                    <text x="75" y="120" text-anchor="middle" fill="white" font-size="12" font-family="Space Grotesk">👩‍🏫</text>
                </svg>
                
                <h2 class="teacher-name">Sindy Martínez Cruz</h2>
                <p class="teacher-title">Docente de Ciencias Sociales</p>
                <div class="recognition-badge">
                    <i class="fas fa-medal"></i> Reconocida como "Docente Ejemplar 2025" en el área de Ciencias Sociales y Humanidades
                </div>
            </div>

            <div class="teacher-content">
                <!-- Biografía -->
                <div class="biography-section">
                    <h3 class="section-title">
                        <i class="fas fa-user-graduate"></i>
                        Biografía
                    </h3>
                    <p class="biography-text">
                        Hola, soy la prof. <strong>Sindy Martínez Cruz</strong>: mamá en construcción, lectora apasionada, cafetera de corazón, radicalmente pacífica y amante de la naturaleza. También disfruto mantenerme activa y disciplinada en mi vida diaria. Estudié sociología, me especialicé en temas de paz y soy magíster en Estudios Urbanos.
                    </p>
                    <p class="biography-text">
                        Tengo más de diez años de experiencia liderando proyectos en el sector público, privado y académico, y actualmente me desempeño como docente de Ciencias Sociales en la Institución Educativa Guillermo Valencia de Cali. Mi vocación es acompañar procesos educativos y sociales que promuevan la paz, los derechos humanos y la convivencia.
                    </p>
                </div>

                <!-- Estadísticas -->
                <div class="stats-container">
                    <div class="stat-item">
                        <span class="stat-number">10+</span>
                        <span class="stat-label">Años de Experiencia</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">Estudiantes Acompañados</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">15</span>
                        <span class="stat-label">Artículos Publicados</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">5</span>
                        <span class="stat-label">Reconocimientos</span>
                    </div>
                </div>

                <!-- Logros y Contribuciones -->
                <div class="biography-section">
                    <h3 class="section-title">
                        <i class="fas fa-trophy"></i>
                        Logros y Contribuciones
                    </h3>
                    <div class="achievements-grid">
                        <div class="achievement-item">
                            <div class="achievement-icon">🏅</div>
                            <div class="achievement-title">Reconocimientos Académicos</div>
                            <div class="achievement-description">
                                Ganadora de estímulos académicos por alto rendimiento en la Universidad del Valle y becaria de Flacso-Ecuador con tesis distinguida.
                            </div>
                        </div>
                        <div class="achievement-item">
                            <div class="achievement-icon">📊</div>
                            <div class="achievement-title">Liderazgo en Observatorios</div>
                            <div class="achievement-description">
                                Lideró el Observatorio de Paz y Cultura Ciudadana en la Alcaldía de Santiago de Cali.
                            </div>
                        </div>
                        <div class="achievement-item">
                            <div class="achievement-icon">🤝</div>
                            <div class="achievement-title">Programas Sociales</div>
                            <div class="achievement-description">
                                Coordinadora de proyectos sociales en Cauca, Valle y Nariño con Fiduagraria S.A. – Equiedad.
                            </div>
                        </div>
                        <div class="achievement-item">
                            <div class="achievement-icon">🏙️</div>
                            <div class="achievement-title">Plan Maestro de Vivienda</div>
                            <div class="achievement-description">
                                Aportó al Plan Maestro de Vivienda de Cali con metodologías participativas y análisis social.
                            </div>
                        </div>
                        <div class="achievement-item">
                            <div class="achievement-icon">✍️</div>
                            <div class="achievement-title">Publicaciones Académicas</div>
                            <div class="achievement-description">
                                Autora de artículos en revistas indexadas sobre participación ciudadana y cambio social.
                            </div>
                        </div>
                        <div class="achievement-item">
                            <div class="achievement-icon">🎓</div>
                            <div class="achievement-title">Educación Transformadora</div>
                            <div class="achievement-description">
                                Realizó un diplomado en pedagogía, reafirmando su compromiso con la educación como herramienta de cambio social.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Razón del Reconocimiento -->
                <div class="recognition-reason">
                    <h3 class="section-title">
                        <i class="fas fa-heart"></i>
                        ¿Por qué la reconocemos?
                    </h3>
                    <p class="biography-text">
                        <strong>La profesora Sindy Martínez es reconocida por ser una persona profundamente humana, justa y comprometida con sus estudiantes.</strong> Su labor no solo se centra en enseñar contenidos académicos, sino en inspirar valores de igualdad, respeto y convivencia.
                    </p>
                    <p class="biography-text">
                        Su enfoque educativo fomenta el pensamiento crítico, la sensibilidad social y el liderazgo transformador en cada estudiante. Gracias a su cercanía y dedicación, ha dejado huellas significativas tanto en la vida académica como personal de quienes acompaña.
                    </p>
                    <p class="biography-text">
                        <em>"La profe Sindy siempre está dispuesta a escucharnos, apoyarnos y motivarnos a ser mejores personas. Nos enseña que la educación es el camino hacia una sociedad más justa e inclusiva."</em> – Testimonio de nosotros.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>





    



    

    
    <!-- Teacher Recognition Section - Luis Mario -->
    <section class="section-padding">
        <div class="container">
            <div class="teacher-card">
                <div class="floating-elements">
                    <div class="floating-icon"><i class="fas fa-star"></i></div>
                    <div class="floating-icon"><i class="fas fa-brain"></i></div>
                    <div class="floating-icon"><i class="fas fa-trophy"></i></div>
                </div>

                <div class="teacher-header text-center">
                    <svg class="teacher-photo" viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="faceGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#4fc3f7;stop-opacity:0.3" />
                                <stop offset="100%" style="stop-color:#9c27b0;stop-opacity:0.3" />
                            </linearGradient>
                        </defs>
                        <circle cx="75" cy="75" r="75" fill="url(#faceGradient)" stroke="#9c27b0" stroke-width="4"/>
                        <circle cx="75" cy="60" r="35" fill="#4fc3f7" opacity="0.8"/>
                        <circle cx="65" cy="55" r="3" fill="white"/>
                        <circle cx="85" cy="55" r="3" fill="white"/>
                        <path d="M 65 70 Q 75 80 85 70" stroke="white" stroke-width="2" fill="none"/>
                        <rect x="60" y="35" width="30" height="15" rx="7" fill="#9c27b0" opacity="0.6"/>
                        <text x="75" y="120" text-anchor="middle" fill="white" font-size="12" font-family="Space Grotesk">👨‍🏫</text>
                    </svg>
                    
                    <h2 class="teacher-name">Luis Mario</h2>
                    <p class="teacher-title">Profesor Titular de Neurociencias Cognitivas</p>
                    <div class="recognition-badge">
                        <i class="fas fa-medal"></i> Docente del Año en: Ética y Valores en este 2025 
                    </div>
                </div>

                <div class="teacher-content">
                    <!-- Biografía -->
                    <div class="biography-section">
                        <h3 class="section-title">
                            <i class="fas fa-user-graduate"></i>
                            Biografía
                        </h3>
                        <p class="biography-text">
                            El Dr. Carlos Mendoza Rivera es un destacado neurocientífico con más de 15 años de experiencia en investigación y docencia. Graduado con honores de la Universidad Nacional, obtuvo su doctorado en Neurociencias Cognitivas en la Universidad de Barcelona. Su pasión por la enseñanza y la investigación lo ha convertido en una figura inspiradora para cientos de estudiantes.
                        </p>
                        <p class="biography-text">
                            Especializado en plasticidad neuronal y aprendizaje, ha dedicado su carrera a entender cómo el cerebro procesa y almacena información, aplicando estos conocimientos para mejorar las metodologías educativas en el aula.
                        </p>
                    </div>

                    <!-- Estadísticas -->
                    <div class="stats-container">
                        <div class="stat-item">
                            <span class="stat-number">15+</span>
                            <span class="stat-label">Años de Experiencia</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">Estudiantes Formados</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">25</span>
                            <span class="stat-label">Publicaciones</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">8</span>
                            <span class="stat-label">Premios Recibidos</span>
                        </div>
                    </div>

                    <!-- Logros y Contribuciones -->
                    <div class="biography-section">
                        <h3 class="section-title">
                            <i class="fas fa-trophy"></i>
                            Logros y Contribuciones
                        </h3>
                        <div class="achievements-grid">
                            <div class="achievement-item">
                                <div class="achievement-icon">📚</div>
                                <div class="achievement-title">Investigación Pionera</div>
                                <div class="achievement-description">
                                    Autor de 25 publicaciones en revistas indexadas sobre plasticidad neuronal y metodologías de aprendizaje innovadoras.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🧠</div>
                                <div class="achievement-title">Laboratorio de Neuroaprendizaje</div>
                                <div class="achievement-description">
                                    Fundador y director del Laboratorio de Neuroaprendizaje, donde se desarrollan técnicas educativas basadas en neurociencia.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🎓</div>
                                <div class="achievement-title">Formación de Nuevos Talentos</div>
                                <div class="achievement-description">
                                    Ha dirigido 12 tesis doctorales y 30 tesis de maestría, formando la próxima generación de neurocientíficos.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🌍</div>
                                <div class="achievement-title">Colaboración Internacional</div>
                                <div class="achievement-description">
                                    Colaborador activo en proyectos de investigación con universidades de España, Estados Unidos y Canadá.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">💡</div>
                                <div class="achievement-title">Innovación Educativa</div>
                                <div class="achievement-description">
                                    Desarrollador de la metodología "NeuroAprendizaje Activo", implementada en más de 20 instituciones educativas.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🏆</div>
                                <div class="achievement-title">Reconocimientos</div>
                                <div class="achievement-description">
                                    Ganador del Premio Nacional de Excelencia Docente 2023 y el Premio de Investigación en Neuroeducación 2022.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Razón del Reconocimiento -->
                    <div class="recognition-reason">
                        <h3 class="section-title">
                            <i class="fas fa-heart"></i>
                            ¿Por qué lo reconocemos?
                        </h3>
                        <p class="biography-text">
                            <strong>El Dr. Mendoza es reconocido por su excepcional dedicación a la excelencia educativa y su impacto transformador en la vida de sus estudiantes.</strong> Su enfoque innovador combina la investigación de vanguardia con una pedagogía centrada en el estudiante, creando experiencias de aprendizaje que van más allá del aula tradicional.
                        </p>
                        <p class="biography-text">
                            Sus estudiantes lo describen como un mentor inspirador que no solo transmite conocimiento, sino que despierta la curiosidad científica y el pensamiento crítico. Su metodología "NeuroAprendizaje Activo" ha revolucionado la forma en que se enseñan las neurociencias, haciendo que conceptos complejos sean accesibles y emocionantes.
                        </p>
                        <p class="biography-text">
                            <em>"El Dr. Mendoza no solo nos enseña sobre el cerebro, nos enseña a pensar con el cerebro. Su pasión es contagiosa y su compromiso con nuestro crecimiento académico y personal es incomparable."</em> - Testimonio de estudiante graduado.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>









    



    
<!-- Teacher Recognition Section - Indira Paola -->
<section class="section-padding">
    <div class="container">
        <div class="teacher-card">
            <div class="floating-elements">
                <div class="floating-icon"><i class="fas fa-star"></i></div>
                <div class="floating-icon"><i class="fas fa-heart"></i></div>
                <div class="floating-icon"><i class="fas fa-book"></i></div>
            </div>

            <div class="teacher-header text-center">
                <!-- Imagen real de Indira -->
                <img src="../img/indira.jpg" alt="Foto de Indira" class="teacher-photo" />

                
                <h2 class="teacher-name">Indira Paola Jara Chávez</h2>
                <p class="teacher-title">Docente de Tecnología e Informática</p>
                <div class="recognition-badge">
                    <i class="fas fa-medal"></i> Docente destacada en 2025 por su entrega y servicio
                </div>
            </div>

            <div class="teacher-content">
                <!-- Biografía -->
                <div class="biography-section">
                    <h3 class="section-title">
                        <i class="fas fa-user-graduate"></i>
                        Biografía
                    </h3>
                    <p class="biography-text">
                        Indira Paola Jara Chávez nació el 3 de marzo de 1978. Estudió Ingeniería de Sistemas y Telemática en la Universidad Santiago de Cali y desde el 2006 inició su camino como docente en la Normal Superior Farallones de Cali. 
                    </p>
                    <p class="biography-text">
                        Ha trabajado en instituciones como el Colegio María Auxiliadora, la Normal Superior y el Colegio Guillermo Valencia, donde ha dejado una huella significativa en la formación de jóvenes, especialmente en la media técnica articulada con el SENA. 
                    </p>
                    <p class="biography-text">
                        También se desempeñó como Secretaria Académica en el Colegio Cooperativo Coomeva y actualmente ejerce como docente en el Colegio Guillermo Valencia, lugar que considera un espacio lleno de gratos recuerdos y aprendizajes.
                    </p>
                    <p class="biography-text">
                        A lo largo de su vida profesional, ha combinado su vocación docente con la crianza de sus tres hijos, demostrando resiliencia, amor y entrega en cada etapa de su vida personal y laboral. Actualmente cursa una Maestría en Educación y se prepara para iniciar un Diplomado en Educación Inclusiva.
                    </p>
                </div>

                <!-- Estadísticas -->
                <div class="stats-container">
                    <div class="stat-item">
                        <span class="stat-number">18+</span>
                        <span class="stat-label">Años de Experiencia</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">1000+</span>
                        <span class="stat-label">Estudiantes Formados</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">5</span>
                        <span class="stat-label">Diplomados y Cursos</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">3</span>
                        <span class="stat-label">Instituciones Educativas</span>
                    </div>
                </div>

                <!-- Logros y Contribuciones -->
                <div class="biography-section">
                    <h3 class="section-title">
                        <i class="fas fa-trophy"></i>
                        Logros y Contribuciones
                    </h3>
                    <div class="achievements-grid">
                        <div class="achievement-item">
                            <div class="achievement-icon">📘</div>
                            <div class="achievement-title">Formación Profesional</div>
                            <div class="achievement-description">
                                Ingeniera de Sistemas y Telemática, con formación en Matemática Articulada, Autocad 2D y actualmente Maestría en Educación.
                            </div>
                        </div>
                        <div class="achievement-item">
                            <div class="achievement-icon">👩‍👧‍👦</div>
                            <div class="achievement-title">Resiliencia</div>
                            <div class="achievement-description">
                                Logró equilibrar su vocación docente con la crianza y acompañamiento de sus tres hijos diagnosticados con TDAH.
                            </div>
                        </div>
                        <div class="achievement-item">
                            <div class="achievement-icon">🏫</div>
                            <div class="achievement-title">Experiencia Educativa</div>
                            <div class="achievement-description">
                                Más de 15 años de docencia en instituciones reconocidas de Cali, dejando huella en distintas generaciones de estudiantes.
                            </div>
                        </div>
                        <div class="achievement-item">
                            <div class="achievement-icon">🌟</div>
                            <div class="achievement-title">Vocación de Servicio</div>
                            <div class="achievement-description">
                                Reconocida por su empatía, sensibilidad y disposición para escuchar y orientar a sus estudiantes.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Razón del Reconocimiento -->
                <div class="recognition-reason">
                    <h3 class="section-title">
                        <i class="fas fa-heart"></i>
                        ¿Por qué la reconocemos?
                    </h3>
                    <p class="biography-text">
                        <strong>Reconocemos a la profe Indira Paola por su amor, sensibilidad y entrega incondicional hacia sus estudiantes.</strong> Es una maestra que no solo enseña, sino que también escucha, guía y acompaña con paciencia y empatía.
                    </p>
                    <p class="biography-text">
                        Sus estudiantes la describen como una persona "muy sensible y llorona", pero con un corazón enorme que transmite fuerza, resiliencia y esperanza. Ella demuestra que enseñar es también servir, y que cada consejo puede llenar vacíos en la vida de un joven.
                    </p>
                    <p class="biography-text">
                        <em>"La reconocemos por ser una maestra tan linda con nosotros, por enseñarnos tanto, pero también por escucharnos y hacernos sentir importantes cada día."</em> - Testimonio de nosotros.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>




    



    

    
    <!-- Teacher Recognition Section - Luis Palta -->
    <section class="section-padding">
        <div class="container">
            <div class="teacher-card">
                <div class="floating-elements">
                    <div class="floating-icon"><i class="fas fa-star"></i></div>
                    <div class="floating-icon"><i class="fas fa-brain"></i></div>
                    <div class="floating-icon"><i class="fas fa-trophy"></i></div>
                </div>

                <div class="teacher-header text-center">
                    <svg class="teacher-photo" viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="faceGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#4fc3f7;stop-opacity:0.3" />
                                <stop offset="100%" style="stop-color:#9c27b0;stop-opacity:0.3" />
                            </linearGradient>
                        </defs>
                        <circle cx="75" cy="75" r="75" fill="url(#faceGradient)" stroke="#9c27b0" stroke-width="4"/>
                        <circle cx="75" cy="60" r="35" fill="#4fc3f7" opacity="0.8"/>
                        <circle cx="65" cy="55" r="3" fill="white"/>
                        <circle cx="85" cy="55" r="3" fill="white"/>
                        <path d="M 65 70 Q 75 80 85 70" stroke="white" stroke-width="2" fill="none"/>
                        <rect x="60" y="35" width="30" height="15" rx="7" fill="#9c27b0" opacity="0.6"/>
                        <text x="75" y="120" text-anchor="middle" fill="white" font-size="12" font-family="Space Grotesk">👨‍🏫</text>
                    </svg>
                    
                    <h2 class="teacher-name">Luis Palta</h2>
                    <p class="teacher-title">Profesor Titular de Neurociencias Cognitivas</p>
                    <div class="recognition-badge">
                        <i class="fas fa-medal"></i> Docente del Año en: Programación en este 2025
                    </div>
                </div>

                <div class="teacher-content">
                    <!-- Biografía -->
                    <div class="biography-section">
                        <h3 class="section-title">
                            <i class="fas fa-user-graduate"></i>
                            Biografía
                        </h3>
                        <p class="biography-text">
                            El Dr. Carlos Mendoza Rivera es un destacado neurocientífico con más de 15 años de experiencia en investigación y docencia. Graduado con honores de la Universidad Nacional, obtuvo su doctorado en Neurociencias Cognitivas en la Universidad de Barcelona. Su pasión por la enseñanza y la investigación lo ha convertido en una figura inspiradora para cientos de estudiantes.
                        </p>
                        <p class="biography-text">
                            Especializado en plasticidad neuronal y aprendizaje, ha dedicado su carrera a entender cómo el cerebro procesa y almacena información, aplicando estos conocimientos para mejorar las metodologías educativas en el aula.
                        </p>
                    </div>

                    <!-- Estadísticas -->
                    <div class="stats-container">
                        <div class="stat-item">
                            <span class="stat-number">15+</span>
                            <span class="stat-label">Años de Experiencia</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">Estudiantes Formados</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">25</span>
                            <span class="stat-label">Publicaciones</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">8</span>
                            <span class="stat-label">Premios Recibidos</span>
                        </div>
                    </div>

                    <!-- Logros y Contribuciones -->
                    <div class="biography-section">
                        <h3 class="section-title">
                            <i class="fas fa-trophy"></i>
                            Logros y Contribuciones
                        </h3>
                        <div class="achievements-grid">
                            <div class="achievement-item">
                                <div class="achievement-icon">📚</div>
                                <div class="achievement-title">Investigación Pionera</div>
                                <div class="achievement-description">
                                    Autor de 25 publicaciones en revistas indexadas sobre plasticidad neuronal y metodologías de aprendizaje innovadoras.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🧠</div>
                                <div class="achievement-title">Laboratorio de Neuroaprendizaje</div>
                                <div class="achievement-description">
                                    Fundador y director del Laboratorio de Neuroaprendizaje, donde se desarrollan técnicas educativas basadas en neurociencia.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🎓</div>
                                <div class="achievement-title">Formación de Nuevos Talentos</div>
                                <div class="achievement-description">
                                    Ha dirigido 12 tesis doctorales y 30 tesis de maestría, formando la próxima generación de neurocientíficos.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🌍</div>
                                <div class="achievement-title">Colaboración Internacional</div>
                                <div class="achievement-description">
                                    Colaborador activo en proyectos de investigación con universidades de España, Estados Unidos y Canadá.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">💡</div>
                                <div class="achievement-title">Innovación Educativa</div>
                                <div class="achievement-description">
                                    Desarrollador de la metodología "NeuroAprendizaje Activo", implementada en más de 20 instituciones educativas.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🏆</div>
                                <div class="achievement-title">Reconocimientos</div>
                                <div class="achievement-description">
                                    Ganador del Premio Nacional de Excelencia Docente 2023 y el Premio de Investigación en Neuroeducación 2022.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Razón del Reconocimiento -->
                    <div class="recognition-reason">
                        <h3 class="section-title">
                            <i class="fas fa-heart"></i>
                            ¿Por qué lo reconocemos?
                        </h3>
                        <p class="biography-text">
                            <strong>El Dr. Mendoza es reconocido por su excepcional dedicación a la excelencia educativa y su impacto transformador en la vida de sus estudiantes.</strong> Su enfoque innovador combina la investigación de vanguardia con una pedagogía centrada en el estudiante, creando experiencias de aprendizaje que van más allá del aula tradicional.
                        </p>
                        <p class="biography-text">
                            Sus estudiantes lo describen como un mentor inspirador que no solo transmite conocimiento, sino que despierta la curiosidad científica y el pensamiento crítico. Su metodología "NeuroAprendizaje Activo" ha revolucionado la forma en que se enseñan las neurociencias, haciendo que conceptos complejos sean accesibles y emocionantes.
                        </p>
                        <p class="biography-text">
                            <em>"El Dr. Mendoza no solo nos enseña sobre el cerebro, nos enseña a pensar con el cerebro. Su pasión es contagiosa y su compromiso con nuestro crecimiento académico y personal es incomparable."</em> - Testimonio de estudiante graduado.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>






    



    

    
    <!-- Teacher Recognition Section - Estefania Nempeque -->
    <section class="section-padding">
        <div class="container">
            <div class="teacher-card">
                <div class="floating-elements">
                    <div class="floating-icon"><i class="fas fa-star"></i></div>
                    <div class="floating-icon"><i class="fas fa-brain"></i></div>
                    <div class="floating-icon"><i class="fas fa-trophy"></i></div>
                </div>

                <div class="teacher-header text-center">
                    <svg class="teacher-photo" viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="faceGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#4fc3f7;stop-opacity:0.3" />
                                <stop offset="100%" style="stop-color:#9c27b0;stop-opacity:0.3" />
                            </linearGradient>
                        </defs>
                        <circle cx="75" cy="75" r="75" fill="url(#faceGradient)" stroke="#9c27b0" stroke-width="4"/>
                        <circle cx="75" cy="60" r="35" fill="#4fc3f7" opacity="0.8"/>
                        <circle cx="65" cy="55" r="3" fill="white"/>
                        <circle cx="85" cy="55" r="3" fill="white"/>
                        <path d="M 65 70 Q 75 80 85 70" stroke="white" stroke-width="2" fill="none"/>
                        <rect x="60" y="35" width="30" height="15" rx="7" fill="#9c27b0" opacity="0.6"/>
                        <text x="75" y="120" text-anchor="middle" fill="white" font-size="12" font-family="Space Grotesk">👨‍🏫</text>
                    </svg>
                    
                    <h2 class="teacher-name">Estefania Nempeque</h2>
                    <p class="teacher-title">Profesor Titular de Neurociencias Cognitivas</p>
                    <div class="recognition-badge">
                        <i class="fas fa-medal"></i> Docente del Año en: English and PILEO en este 2025 
                    </div>
                </div>

                <div class="teacher-content">
                    <!-- Biografía -->
                    <div class="biography-section">
                        <h3 class="section-title">
                            <i class="fas fa-user-graduate"></i>
                            Biografía
                        </h3>
                        <p class="biography-text">
                            El Dr. Carlos Mendoza Rivera es un destacado neurocientífico con más de 15 años de experiencia en investigación y docencia. Graduado con honores de la Universidad Nacional, obtuvo su doctorado en Neurociencias Cognitivas en la Universidad de Barcelona. Su pasión por la enseñanza y la investigación lo ha convertido en una figura inspiradora para cientos de estudiantes.
                        </p>
                        <p class="biography-text">
                            Especializado en plasticidad neuronal y aprendizaje, ha dedicado su carrera a entender cómo el cerebro procesa y almacena información, aplicando estos conocimientos para mejorar las metodologías educativas en el aula.
                        </p>
                    </div>

                    <!-- Estadísticas -->
                    <div class="stats-container">
                        <div class="stat-item">
                            <span class="stat-number">15+</span>
                            <span class="stat-label">Años de Experiencia</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">Estudiantes Formados</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">25</span>
                            <span class="stat-label">Publicaciones</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">8</span>
                            <span class="stat-label">Premios Recibidos</span>
                        </div>
                    </div>

                    <!-- Logros y Contribuciones -->
                    <div class="biography-section">
                        <h3 class="section-title">
                            <i class="fas fa-trophy"></i>
                            Logros y Contribuciones
                        </h3>
                        <div class="achievements-grid">
                            <div class="achievement-item">
                                <div class="achievement-icon">📚</div>
                                <div class="achievement-title">Investigación Pionera</div>
                                <div class="achievement-description">
                                    Autor de 25 publicaciones en revistas indexadas sobre plasticidad neuronal y metodologías de aprendizaje innovadoras.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🧠</div>
                                <div class="achievement-title">Laboratorio de Neuroaprendizaje</div>
                                <div class="achievement-description">
                                    Fundador y director del Laboratorio de Neuroaprendizaje, donde se desarrollan técnicas educativas basadas en neurociencia.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🎓</div>
                                <div class="achievement-title">Formación de Nuevos Talentos</div>
                                <div class="achievement-description">
                                    Ha dirigido 12 tesis doctorales y 30 tesis de maestría, formando la próxima generación de neurocientíficos.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🌍</div>
                                <div class="achievement-title">Colaboración Internacional</div>
                                <div class="achievement-description">
                                    Colaborador activo en proyectos de investigación con universidades de España, Estados Unidos y Canadá.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">💡</div>
                                <div class="achievement-title">Innovación Educativa</div>
                                <div class="achievement-description">
                                    Desarrollador de la metodología "NeuroAprendizaje Activo", implementada en más de 20 instituciones educativas.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🏆</div>
                                <div class="achievement-title">Reconocimientos</div>
                                <div class="achievement-description">
                                    Ganador del Premio Nacional de Excelencia Docente 2023 y el Premio de Investigación en Neuroeducación 2022.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Razón del Reconocimiento -->
                    <div class="recognition-reason">
                        <h3 class="section-title">
                            <i class="fas fa-heart"></i>
                            ¿Por qué lo reconocemos?
                        </h3>
                        <p class="biography-text">
                            <strong>El Dr. Mendoza es reconocido por su excepcional dedicación a la excelencia educativa y su impacto transformador en la vida de sus estudiantes.</strong> Su enfoque innovador combina la investigación de vanguardia con una pedagogía centrada en el estudiante, creando experiencias de aprendizaje que van más allá del aula tradicional.
                        </p>
                        <p class="biography-text">
                            Sus estudiantes lo describen como un mentor inspirador que no solo transmite conocimiento, sino que despierta la curiosidad científica y el pensamiento crítico. Su metodología "NeuroAprendizaje Activo" ha revolucionado la forma en que se enseñan las neurociencias, haciendo que conceptos complejos sean accesibles y emocionantes.
                        </p>
                        <p class="biography-text">
                            <em>"El Dr. Mendoza no solo nos enseña sobre el cerebro, nos enseña a pensar con el cerebro. Su pasión es contagiosa y su compromiso con nuestro crecimiento académico y personal es incomparable."</em> - Testimonio de estudiante graduado.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>





    



    

    
    <!-- Teacher Recognition Section - Alexander Ordoñez -->
    <section class="section-padding">
        <div class="container">
            <div class="teacher-card">
                <div class="floating-elements">
                    <div class="floating-icon"><i class="fas fa-star"></i></div>
                    <div class="floating-icon"><i class="fas fa-brain"></i></div>
                    <div class="floating-icon"><i class="fas fa-trophy"></i></div>
                </div>

                <div class="teacher-header text-center">
                    <svg class="teacher-photo" viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="faceGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#4fc3f7;stop-opacity:0.3" />
                                <stop offset="100%" style="stop-color:#9c27b0;stop-opacity:0.3" />
                            </linearGradient>
                        </defs>
                        <circle cx="75" cy="75" r="75" fill="url(#faceGradient)" stroke="#9c27b0" stroke-width="4"/>
                        <circle cx="75" cy="60" r="35" fill="#4fc3f7" opacity="0.8"/>
                        <circle cx="65" cy="55" r="3" fill="white"/>
                        <circle cx="85" cy="55" r="3" fill="white"/>
                        <path d="M 65 70 Q 75 80 85 70" stroke="white" stroke-width="2" fill="none"/>
                        <rect x="60" y="35" width="30" height="15" rx="7" fill="#9c27b0" opacity="0.6"/>
                        <text x="75" y="120" text-anchor="middle" fill="white" font-size="12" font-family="Space Grotesk">👨‍🏫</text>
                    </svg>
                    
                    <h2 class="teacher-name">Alexander Ordoñez</h2>
                    <p class="teacher-title">Profesor Titular de Neurociencias Cognitivas</p>
                    <div class="recognition-badge">
                        <i class="fas fa-medal"></i> Docente del Año en: Lengua Castellana en este 2025 
                    </div>
                </div>

                <div class="teacher-content">
                    <!-- Biografía -->
                    <div class="biography-section">
                        <h3 class="section-title">
                            <i class="fas fa-user-graduate"></i>
                            Biografía
                        </h3>
                        <p class="biography-text">
                            El Dr. Carlos Mendoza Rivera es un destacado neurocientífico con más de 15 años de experiencia en investigación y docencia. Graduado con honores de la Universidad Nacional, obtuvo su doctorado en Neurociencias Cognitivas en la Universidad de Barcelona. Su pasión por la enseñanza y la investigación lo ha convertido en una figura inspiradora para cientos de estudiantes.
                        </p>
                        <p class="biography-text">
                            Especializado en plasticidad neuronal y aprendizaje, ha dedicado su carrera a entender cómo el cerebro procesa y almacena información, aplicando estos conocimientos para mejorar las metodologías educativas en el aula.
                        </p>
                    </div>

                    <!-- Estadísticas -->
                    <div class="stats-container">
                        <div class="stat-item">
                            <span class="stat-number">15+</span>
                            <span class="stat-label">Años de Experiencia</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">Estudiantes Formados</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">25</span>
                            <span class="stat-label">Publicaciones</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">8</span>
                            <span class="stat-label">Premios Recibidos</span>
                        </div>
                    </div>

                    <!-- Logros y Contribuciones -->
                    <div class="biography-section">
                        <h3 class="section-title">
                            <i class="fas fa-trophy"></i>
                            Logros y Contribuciones
                        </h3>
                        <div class="achievements-grid">
                            <div class="achievement-item">
                                <div class="achievement-icon">📚</div>
                                <div class="achievement-title">Investigación Pionera</div>
                                <div class="achievement-description">
                                    Autor de 25 publicaciones en revistas indexadas sobre plasticidad neuronal y metodologías de aprendizaje innovadoras.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🧠</div>
                                <div class="achievement-title">Laboratorio de Neuroaprendizaje</div>
                                <div class="achievement-description">
                                    Fundador y director del Laboratorio de Neuroaprendizaje, donde se desarrollan técnicas educativas basadas en neurociencia.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🎓</div>
                                <div class="achievement-title">Formación de Nuevos Talentos</div>
                                <div class="achievement-description">
                                    Ha dirigido 12 tesis doctorales y 30 tesis de maestría, formando la próxima generación de neurocientíficos.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🌍</div>
                                <div class="achievement-title">Colaboración Internacional</div>
                                <div class="achievement-description">
                                    Colaborador activo en proyectos de investigación con universidades de España, Estados Unidos y Canadá.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">💡</div>
                                <div class="achievement-title">Innovación Educativa</div>
                                <div class="achievement-description">
                                    Desarrollador de la metodología "NeuroAprendizaje Activo", implementada en más de 20 instituciones educativas.
                                </div>
                            </div>
                            <div class="achievement-item">
                                <div class="achievement-icon">🏆</div>
                                <div class="achievement-title">Reconocimientos</div>
                                <div class="achievement-description">
                                    Ganador del Premio Nacional de Excelencia Docente 2023 y el Premio de Investigación en Neuroeducación 2022.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Razón del Reconocimiento -->
                    <div class="recognition-reason">
                        <h3 class="section-title">
                            <i class="fas fa-heart"></i>
                            ¿Por qué lo reconocemos?
                        </h3>
                        <p class="biography-text">
                            <strong>El Dr. Mendoza es reconocido por su excepcional dedicación a la excelencia educativa y su impacto transformador en la vida de sus estudiantes.</strong> Su enfoque innovador combina la investigación de vanguardia con una pedagogía centrada en el estudiante, creando experiencias de aprendizaje que van más allá del aula tradicional.
                        </p>
                        <p class="biography-text">
                            Sus estudiantes lo describen como un mentor inspirador que no solo transmite conocimiento, sino que despierta la curiosidad científica y el pensamiento crítico. Su metodología "NeuroAprendizaje Activo" ha revolucionado la forma en que se enseñan las neurociencias, haciendo que conceptos complejos sean accesibles y emocionantes.
                        </p>
                        <p class="biography-text">
                            <em>"El Dr. Mendoza no solo nos enseña sobre el cerebro, nos enseña a pensar con el cerebro. Su pasión es contagiosa y su compromiso con nuestro crecimiento académico y personal es incomparable."</em> - Testimonio de estudiante graduado.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>





    



    

    
   <!-- Teacher Recognition Section - Paola Andrea Ortiz Ramírez -->
<section class="section-padding">
    <div class="container">
        <div class="teacher-card">
            <div class="floating-elements">
                <div class="floating-icon"><i class="fas fa-music"></i></div>
                <div class="floating-icon"><i class="fas fa-paint-brush"></i></div>
                <div class="floating-icon"><i class="fas fa-heart"></i></div>
            </div>

            <div class="teacher-header text-center">
                <!-- Imagen real de Paola -->
                <img src="../img/paola.png" alt="Foto de Paola Andrea Ortiz Ramírez" class="teacher-photo" />

                <h2 class="teacher-name">Paola Andrea Ortiz Ramírez</h2>
                <p class="teacher-title">Docente de Educación Artística</p>
                <div class="recognition-badge">
                    <i class="fas fa-medal"></i> Reconocida como "Docente Ejemplar 2025" en el área de Artes y Humanidades
                </div>
            </div>

            <div class="teacher-content">
                <!-- Biografía -->
                <div class="biography-section">
                    <h3 class="section-title">
                        <i class="fas fa-user-graduate"></i>
                        Biografía
                    </h3>
                    <p class="biography-text">
                        <strong>Paola Andrea Ortiz Ramírez</strong> (Cali, 26 de septiembre de 1995) es Licenciada en Educación Básica con énfasis en Educación Artística, egresada con grado de honor de la Fundación Universitaria Católica Lumen Gentium, maestrante en Educación en la Universidad Icesi y docente en la Institución Educativa Guillermo Valencia de Cali.
                    </p>
                    <p class="biography-text">
                        Su trayectoria inició en el Centro Cultural Abriendo Puertas, donde lideró proyectos de arte, ciudadanía juvenil y educación socioemocional, integrando posteriormente agrupaciones artísticas como <em>Alto Volumen</em> y el <em>Coro Ciudad de Cali</em>. Actualmente es cofundadora de <strong>Lirius</strong>, cuarteto acústico interdisciplinario que promueve la creatividad cultural.
                    </p>
                    <p class="biography-text">
                        Ha desarrollado propuestas como <em>“Ciudadanía desde el arte”</em>, seleccionada por <strong>EDUCAPAZ</strong>, y ha participado en festivales como <em>Caminantes Fest</em>, consolidando el arte como escenario de diálogo y ciudadanía. Además, fue tutora en el proyecto Maestro Itinerante de la UNAD y docente en el Sistema Educativo Comfandi, donde impulsó la innovación pedagógica.
                    </p>
                    <p class="biography-text">
                        En el aula, transforma la enseñanza de las artes al integrar música, teatro, danza, performance y artes visuales, generando experiencias integrales que promueven sensibilidad, pensamiento crítico y construcción de comunidad.
                    </p>
                </div>

                <!-- Estadísticas -->
                <div class="stats-container">
                    <div class="stat-item">
                        <span class="stat-number">8+</span>
                        <span class="stat-label">Años de Experiencia</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">400+</span>
                        <span class="stat-label">Estudiantes Impactados</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">10+</span>
                        <span class="stat-label">Ponencias en Congresos</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">5</span>
                        <span class="stat-label">Reconocimientos Culturales</span>
                    </div>
                </div>

                <!-- Logros y Contribuciones -->
                <div class="biography-section">
                    <h3 class="section-title">
                        <i class="fas fa-trophy"></i>
                        Logros y Contribuciones
                    </h3>
                    <div class="achievements-grid">
                        <div class="achievement-item">
                            <div class="achievement-icon">🎓</div>
                            <div class="achievement-title">Grado de Honor</div>
                            <div class="achievement-description">
                                Reconocida como egresada de honor en su licenciatura en Educación Artística en UNICATÓLICA.
                            </div>
                        </div>
                        <div class="achievement-item">
                            <div class="achievement-icon">🎤</div>
                            <div class="achievement-title">Participación Artística</div>
                            <div class="achievement-description">
                                Integrante del colectivo juvenil <em>Alto Volumen</em>, soprano en el Coro Ciudad de Cali y cofundadora de <em>Lirius</em>.
                            </div>
                        </div>
                        <div class="achievement-item">
                            <div class="achievement-icon">🎬</div>
                            <div class="achievement-title">Ciudadanía desde el Arte</div>
                            <div class="achievement-description">
                                Impulsó la creación del documental y festival <em>Caminantes Fest</em>, financiados por <strong>EDUCAPAZ</strong>.
                            </div>
                        </div>
                        <div class="achievement-item">
                            <div class="achievement-icon">📚</div>
                            <div class="achievement-title">Innovación Pedagógica</div>
                            <div class="achievement-description">
                                Experiencia en Comfandi y en la UNAD, liderando proyectos de reconciliación y educación comunitaria.
                            </div>
                        </div>
                        <div class="achievement-item">
                            <div class="achievement-icon">🌍</div>
                            <div class="achievement-title">Ponencias Internacionales</div>
                            <div class="achievement-description">
                                Ha compartido sus experiencias en congresos nacionales e internacionales sobre educación artística y ciudadanía.
                            </div>
                        </div>
                        <div class="achievement-item">
                            <div class="achievement-icon">🏆</div>
                            <div class="achievement-title">Reconocimientos</div>
                            <div class="achievement-description">
                                Destacada por su aporte al Arte y la Cultura como egresada de UNICATÓLICA.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Razón del Reconocimiento -->
                <div class="recognition-reason">
                    <h3 class="section-title">
                        <i class="fas fa-heart"></i>
                        ¿Por qué la reconocemos?
                    </h3>
                    <p class="biography-text">
                        <strong>Reconocemos a la profesora Paola Andrea Ortiz Ramírez por su dedicación, creatividad y pasión al enseñar.</strong> Siempre motiva a sus estudiantes a esforzarse y demostrar que todo es posible a través del arte en sus múltiples formas.
                    </p>
                    <p class="biography-text">
                        Su forma de guiar combina disciplina con inspiración, generando espacios donde la música, la danza, el teatro y las artes visuales se convierten en herramientas de transformación personal y social.
                    </p>
                    <p class="biography-text">
                        <em>"La profe Paola nos enseña que el arte no es solo expresión, sino también ciudadanía, paz y esperanza. Gracias a ella creemos que sí se puede."</em> – Testimonio de estudiante.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

    <footer class="py-4 mt-5" data-aos="fade-up">
        <div class="container text-center">
            <p class="footer-text">© 2025 Sinaptium. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animación de entrada para las tarjetas de logros
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Aplicar animación a los elementos de logros
        document.querySelectorAll('.achievement-item').forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(30px)';
            item.style.transition = `all 0.6s ease ${index * 0.1}s`;
            observer.observe(item);
        });

        // Efecto de contador para las estadísticas
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(current) + (target >= 100 ? '+' : '');
            }, 30);
        }

        // Inicializar contadores cuando sean visibles
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const number = entry.target.querySelector('.stat-number');
                    const target = parseInt(number.textContent);
                    animateCounter(number, target);
                    statsObserver.unobserve(entry.target);
                }
            });
        });

        document.querySelectorAll('.stat-item').forEach(item => {
            statsObserver.observe(item);
        });
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'981acc5a0554b25a',t:'MTc1ODMwMjg5My4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
