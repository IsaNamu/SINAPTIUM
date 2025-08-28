// matematicas.js

document.addEventListener('DOMContentLoaded', function() {
    const questions = [
        {
            question: "¿Cómo prefieres estudiar eventos históricos complejos?",
            options: [
                { text: "Viendo líneas de tiempo interactivas, mapas históricos o documentales visuales.", type: "visual" },
                { text: "Escuchando podcasts de historia, audiodramas o debates de expertos.", type: "auditivo" },
                { text: "Creando maquetas de batallas, visitando museos o recreando momentos históricos.", type: "kinestesico" }
            ]
        },
        {
            question: "¿Qué método te ayuda más a comprender la geografía física y política?",
            options: [
                { text: "Estudiando mapas detallados, globos terráqueos o imágenes satelitales.", type: "visual" },
                { text: "Escuchando descripciones de paisajes, nombres de lugares y características geográficas.", type: "auditivo" },
                { text: "Construyendo modelos de terreno, maquetas de ciudades o realizando excursiones geográficas.", type: "kinestesico" }            ]
        },
        {
            question: "¿Cómo prefieres aprender sobre diferentes culturas y sociedades?",
            options: [
                { text: "Viendo fotografías, videos de viajes o exposiciones de arte de otras culturas.", type: "visual" },
                { text: "Escuchando música tradicional, entrevistas con personas de otras culturas o relatos orales.", type: "auditivo" },
                { text: "Participando en festivales culturales, cocinando platos típicos o aprendiendo danzas tradicionales.", type: "kinestesico" }
            ]
        },
        {
            question: "¿Al analizar problemas sociales o económicos, qué enfoque prefieres?",
            options: [
                { text: "Estudiando gráficos, estadísticas, infografías o diagramas de flujo de procesos económicos.", type: "visual" },
                { text: "Escuchando análisis económicos de expertos, debates sobre políticas sociales o programas de radio.", type: "auditivo" },
                { text: "Participando en simulaciones de mercado, juegos de roles sobre políticas o visitando empresas/ONGs.", type: "kinestesico" }
            ]
        },
        {
            question: "¿Cómo te sientes más cómodo al preparar un proyecto o presentación de Sociales?",
            options: [
                { text: "Diseñando presentaciones con muchas imágenes, mapas o videos, y usando gráficos impactantes.", type: "visual" },
                { text: "Practicando la presentación en voz alta, grabando mi voz o escuchando grabaciones de discursos.", type: "auditivo" },
                { text: "Creando materiales interactivos, realizando dramatizaciones o moviéndome mientras presento.", type: "kinestesico" }
            ]
        }
    ];

    const testQuestionsDiv = document.getElementById('testQuestions');
    const learningStyleTestForm = document.getElementById('learningStyleTest');
    const testResultDiv = document.getElementById('testResult');
    const detectedStyleSpan = document.getElementById('detectedStyle');
    const userNameInput = document.getElementById('userName');

    // Función para renderizar preguntas usando un ciclo 'for'
    function renderQuestions() {
        testQuestionsDiv.innerHTML = ''; // Limpiar preguntas anteriores
        for (let i = 0; i < questions.length; i++) {
            const q = questions[i];
            let optionsHtml = '';
            // Usando un ciclo 'forEach' para las opciones
            q.options.forEach((option, optIndex) => {
                optionsHtml += `
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question${i}" id="q${i}o${optIndex}" value="${option.type}" required>
                        <label class="form-check-label" for="q${i}o${optIndex}">
                            ${option.text}
                        </label>
                    </div>
                `;
            });
            const questionHtml = `
                <div class="mb-4">
                    <p class="mb-2 text-white-75">${i + 1}. ${q.question}</p>
                    ${optionsHtml}
                </div>
            `;
            testQuestionsDiv.innerHTML += questionHtml;
        }
    }

    // Función para calcular y enviar los resultados
    learningStyleTestForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir el envío del formulario por defecto

        let userScores = {
            visual: 0,
            auditivo: 0,
            kinestesico: 0
        };

        // Recorrer las preguntas para obtener las respuestas y calcular puntajes
        for (let i = 0; i < questions.length; i++) {
            const selectedOption = document.querySelector(`input[name="question${i}"]:checked`);
            if (selectedOption) {
                userScores[selectedOption.value]++;
            }
        }

        let detectedStyle = 'No detectado';
        let maxScore = -1;

        // Encontrar el estilo con el puntaje más alto
        // Usando un ciclo 'for...in'
        for (let style in userScores) {
            if (userScores.hasOwnProperty(style)) { // Asegurarse de que sea una propiedad propia
                if (userScores[style] > maxScore) {
                    maxScore = userScores[style];
                    detectedStyle = style;
                }
            }
        }

        const userName = userNameInput.value.trim();
        const area = "Sociales"; // Área actual

        if (!userName) {
            alert("Por favor, ingresa tu nombre o alias.");
            return;
        }

        // Mostrar resultado detectado
        detectedStyleSpan.textContent = detectedStyle.charAt(0).toUpperCase() + detectedStyle.slice(1);
        testResultDiv.style.display = 'block';

        // Enviar datos a matematicas.php usando AJAX
        fetch('sociales.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `userName=${encodeURIComponent(userName)}&area=${encodeURIComponent(area)}&tipoAprendizaje=${encodeURIComponent(detectedStyle)}`
        })
        .then(response => response.text())
        .then(data => {
            console.log('Respuesta del servidor:', data);
            // Redirigir a la página de recursos específica después de un breve retraso
            setTimeout(() => {
                window.location.href = `../sociales/sociales_${detectedStyle}.html`;
            }, 1000); // Redirigir después de 1.5 segundos
        })
        .catch(error => {
            console.error('Error al guardar el estilo de aprendizaje:', error);
            alert('Hubo un error al guardar tu estilo de aprendizaje. Por favor, inténtalo de nuevo.');
            // Incluso si hay un error, intentar redirigir para no dejar al usuario varado
            setTimeout(() => {
                window.location.href = `../sociales/sociales_${detectedStyle}.html`;
            }, 1000);
        });
    });

    // Renderizar las preguntas al cargar la página
    renderQuestions();
});

