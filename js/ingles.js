// ingles.js

document.addEventListener('DOMContentLoaded', function() {
    const questions = [
        {
            question: "¿Cómo prefieres estudiar gramática y estructura de oraciones?",
            options: [
                { text: "Viendo diagramas de oraciones, infografías de reglas gramaticales o videos explicativos.", type: "visual" },
                { text: "Escuchando explicaciones de gramática, audiolibros o canciones con la letra.", type: "auditivo" },
                { text: "Escribiendo oraciones, haciendo tarjetas de memoria (flashcards) o participando en juegos de roles.", type: "kinestesico" }
            ]
        },
        {
            question: "¿Qué método te ayuda más a aprender nuevo vocabulario?",
            options: [
                { text: "Usando aplicaciones con imágenes, diccionarios visuales o flashcards con fotos.", type: "visual" },
                { text: "Escuchando audios de palabras, repitiendo en voz alta o usando aplicaciones de pronunciación.", type: "auditivo" },
                { text: "Escribiendo listas de palabras, actuando escenas con vocabulario o usando juegos de palabras.", type: "kinestesico" }
            ]
        },
        {
            question: "¿Cómo te sientes más cómodo practicando la conversación en inglés?",
            options: [
                { text: "Viendo videos de conversaciones, series con subtítulos o lecturas con imágenes.", type: "visual" },
                { text: "Escuchando a hablantes nativos, practicando diálogos con audio o escuchando podcasts de entrevistas.", type: "auditivo" },
                { text: "Participando en juegos de mesa con otros, simulando situaciones o en un intercambio de idiomas en persona.", type: "kinestesico" }
            ]
        },
        {
            question: "¿Al leer un texto en inglés, qué enfoque prefieres?",
            options: [
                { text: "Estudiando gráficos, estadísticas, infografías o diagramas de flujo de procesos económicos.", type: "visual" },
                { text: "Escuchando análisis económicos de expertos, debates sobre políticas sociales o programas de radio.", type: "auditivo" },
                { text: "Participando en simulaciones de mercado, juegos de roles sobre políticas o visitando empresas/ONGs.", type: "kinestesico" }
            ]
        },
        {
            question: "¿Cómo te sientes más cómodo al preparar un proyecto o presentación en inglés?",
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
    const userNameDisplay = document.getElementById('userNameDisplay');

    function renderQuestions() {
        testQuestionsDiv.innerHTML = '';
        questions.forEach((q, index) => {
            const questionHtml = `
                <div class="question-card mb-4 p-4">
                    <h5 class="question-text">${index + 1}. ${q.question}</h5>
                    <div class="options-group mt-3">
                        ${q.options.map(option => `
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question${index}" id="option${index}-${option.type}" value="${option.type}" required>
                                <label class="form-check-label" for="option${index}-${option.type}">
                                    ${option.text}
                                </label>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
            testQuestionsDiv.innerHTML += questionHtml;
        });
    }

    learningStyleTestForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const formData = new FormData(learningStyleTestForm);
        const results = {
            visual: 0,
            auditivo: 0,
            kinestesico: 0
        };

        let totalQuestions = 0;
        for (const [key, value] of formData.entries()) {
            if (key.startsWith('question')) {
                results[value]++;
                totalQuestions++;
            }
        }

        let detectedStyle = 'kinestesico'; // Valor por defecto
        let maxScore = 0;

        if (results.visual > maxScore) {
            maxScore = results.visual;
            detectedStyle = 'visual';
        }
        if (results.auditivo > maxScore) {
            maxScore = results.auditivo;
            detectedStyle = 'auditivo';
        }
        if (results.kinestesico > maxScore) {
            maxScore = results.kinestesico;
            detectedStyle = 'kinestesico';
        }

        const userName = userNameInput.value;
        const area = 'ingles';

        userNameDisplay.textContent = userName;
        detectedStyleSpan.textContent = detectedStyle.charAt(0).toUpperCase() + detectedStyle.slice(1);
        testResultDiv.style.display = 'block';

        // Enviar datos a ingles.php usando AJAX
        fetch('ingles.php', {
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
                window.location.href = `../ingles/ingles_${detectedStyle}.html`;
            }, 1000); // Redirigir después de 1 segundo
        })
        .catch(error => {
            console.error('Error al guardar el estilo de aprendizaje:', error);
            alert('Hubo un error al guardar tu estilo de aprendizaje. Por favor, inténtalo de nuevo.');
            // Incluso si hay un error, intentar redirigir para no dejar al usuario varado
            setTimeout(() => {
                window.location.href = `../ingles/ingles_${detectedStyle}.html`;
            }, 1000);
        });
    });

    // Renderizar las preguntas al cargar la página
    renderQuestions();
});