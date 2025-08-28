// ciencias_naturales.js

document.addEventListener('DOMContentLoaded', function() {
    const questions = [
        {
            question: "¿Cómo prefieres estudiar el ciclo del agua?",
            options: [
                { text: "Viendo un diagrama interactivo o una infografía que ilustre todas las etapas del proceso.", type: "visual" },
                { text: "Escuchando una explicación narrada o un podcast que describa cada fase del ciclo.", type: "auditivo" },
                { text: "Construyendo un modelo pequeño del ciclo o realizando un experimento de condensación.", type: "kinestesico" }
            ]
        },
        {
            question: "¿Qué método te ayuda más a comprender la estructura de una célula?",
            options: [
                { text: "Observando un modelo 3D detallado o un video animado de sus orgánulos.", type: "visual" },
                { text: "Escuchando una descripción verbal de cada parte y su función.", type: "auditivo" },
                { text: "Creando una maqueta de la célula con materiales cotidianos como gelatina y dulces.", type: "kinestesico" }
            ]
        },
        {
            question: "¿Cómo prefieres aprender sobre los ecosistemas?",
            options: [
                { text: "Viendo documentales sobre diferentes biomas y sus especies, con fotos de animales y plantas.", type: "visual" },
                { text: "Escuchando a un experto describir los sonidos y relaciones entre las especies en un ecosistema.", type: "auditivo" },
                { text: "Simulando un ecosistema en un terrario o visitando un jardín botánico para interactuar con la naturaleza.", type: "kinestesico" }
            ]
        },
        {
            question: "¿Cómo te resulta más fácil aprender las leyes de la física, como la gravedad?",
            options: [
                { text: "Viendo videos de demostraciones o diagramas que ilustren la fuerza y el movimiento.", type: "visual" },
                { text: "Escuchando conferencias o debates que expliquen los principios de forma teórica.", type: "auditivo" },
                { text: "Realizando experimentos prácticos, como dejar caer objetos de diferentes pesos y medir su velocidad.", type: "kinestesico" }
            ]
        },
        {
            question: "¿Cuál es la mejor forma para que asimiles las etapas de la fotosíntesis?",
            options: [
                { text: "Analizando un gráfico que muestra el flujo de energía y los compuestos químicos.", type: "visual" },
                { text: "Escuchando una canción o una explicación verbal paso a paso del proceso.", type: "auditivo" },
                { text: "Plantando una semilla y observando su crecimiento, o simulando el proceso en un laboratorio virtual.", type: "kinestesico" }
            ]
        }
    ];

    const testContainer = document.getElementById('testQuestions');
    const form = document.getElementById('learningStyleTest');
    const testResultDiv = document.getElementById('testResult');
    const userNameDisplay = document.getElementById('userNameDisplay');
    const detectedStyleSpan = document.getElementById('detectedStyle');

    // Función para renderizar las preguntas
    const renderQuestions = () => {
        let html = '';
        questions.forEach((q, index) => {
            html += `
                <div class="question-card mb-4 p-4 rounded" data-aos="fade-up">
                    <p class="question-text">${q.question}</p>
                    <div class="options-container">
            `;
            q.options.forEach(option => {
                html += `
                        <div class="form-check custom-radio">
                            <input class="form-check-input" type="radio" name="question${index}" id="option${index}-${option.type}" value="${option.type}" required>
                            <label class="form-check-label" for="option${index}-${option.type}">
                                ${option.text}
                            </label>
                        </div>
                `;
            });
            html += `
                    </div>
                </div>
            `;
        });
        testContainer.innerHTML = html;
    };

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const userName = document.getElementById('userName').value;
        const area = 'Ciencias Naturales';
        const formData = new FormData(form);
        const userAnswers = {};
        
        for (let [key, value] of formData.entries()) {
            if (key !== 'userName') {
                userAnswers[key] = value;
            }
        }
        
        let scores = {
            visual: 0,
            auditivo: 0,
            kinestesico: 0
        };
        
        let totalQuestions = Object.keys(userAnswers).length;
        
        for (let key in userAnswers) {
            scores[userAnswers[key]]++;
        }
        
        let maxScore = 0;
        let detectedStyle = 'desconocido';
        
        for (let style in scores) {
            if (scores[style] > maxScore) {
                maxScore = scores[style];
                detectedStyle = style;
            } else if (scores[style] === maxScore) {
                // Si hay empate, se podría aplicar una lógica adicional o simplemente elegir uno
                // Aquí, el primero en la lista de 'scores' en caso de empate se mantiene
            }
        }

        userNameDisplay.textContent = userName;
        detectedStyleSpan.textContent = detectedStyle.charAt(0).toUpperCase() + detectedStyle.slice(1);
        testResultDiv.style.display = 'block';

        // Enviar datos a php usando AJAX
        fetch('ciencias_naturales.php', {
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
                window.location.href = `../ciencias_naturales/ciencias_naturales_${detectedStyle}.html`;
            }, 1000); // Redirigir después de 1 segundo
        })
        .catch(error => {
            console.error('Error al guardar el estilo de aprendizaje:', error);
            alert('Hubo un error al guardar tu estilo de aprendizaje. Por favor, inténtalo de nuevo.');
            // Incluso si hay un error, intentar redirigir para no dejar al usuario varado
            setTimeout(() => {
                window.location.href = `../ciencias_naturales/ciencias_naturales_${detectedStyle}.html`;
            }, 1000);
        });
    });

    // Renderizar las preguntas al cargar
    renderQuestions();
});