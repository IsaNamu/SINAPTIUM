// Datos del test
const questions = [
    "Prefiero hacer un mapa que explicarle a alguien como tiene que encontrar un lugar.",
    "Si estoy enojado(a) o contento (a) generalmente sé exactamente por qué.",
    "Sé tocar (o antes sabía tocar) un instrumento musical.",
    "Asoció la música con mis estados de ánimo.",
    "Puedo sumar o multiplicar mentalmente con mucha rapidez.",
    "Puedo ayudar a un amigo a manejar sus sentimientos porque yo lo pude hacer antes en relación a sentimientos parecidos.",
    "Me gusta trabajar con calculadoras y computadores.",
    "Aprendo rápido a bailar un baile nuevo.",
    "No me es difícil decir lo que pienso en el curso de una discusión o debate.",
    "Disfruto de una buena charla, discurso o sermón.",
    "Siempre distingo el norte del sur, esté donde esté.",
    "Me gusta reunir grupos de personas en una fiesta o en un evento especial.",
    "La vida me parece vacía sin música.",
    "Siempre entiendo los gráficos que vienen en las instrucciones de los equipos.",
    "Me gusta dibujar paisajes y pasar tiempo en contacto con la naturaleza.",
    "Me fue fácil aprender a andar en bicicleta. (O patines)",
    "Me enojo cuando oigo una discusión o una afirmación que parece ilógica.",
    "Soy capaz de convencer a otros que sigan mis planes.",
    "Tengo buen sentido de equilibrio y coordinación.",
    "Con frecuencia veo y relaciono los números con más rapidez y facilidad que otros.",
    "Me gusta construir modelos (o hacer esculturas).",
    "Tengo agudeza para encontrar el significado de las palabras.",
    "Puedo mirar un objeto de una manera y con la misma facilidad verlo.",
    "Tengo facilidad en relacionar una pieza de música y algún evento de la vida.",
    "Conozco los nombres de algunas plantas y su uso en las diferentes áreas.",
    "Me gusta sentarme silenciosamente y reflexionar sobre mis sentimientos íntimos.",
    "Con sólo mirar la forma de construcciones y estructuras me siento a gusto.",
    "Me gusta tararear, silbar y cantar en la ducha o cuando estoy sola.",
    "Me gusta conocer los misterios de la naturaleza.",
    "Con solo mirar los animales se, si alguno está enfermo.",
    "Generalmente me doy cuenta de la expresión que tengo en la cara.",
    "Me doy cuenta de las expresiones en la cara de otras personas.",
    "Me mantengo 'en contacto' con mis estados de ánimo. No me cuesta identificarlos.",
    "Me doy cuenta de los estados de ánimo de otros.",
    "Me doy cuenta bastante bien de lo que otros piensan de mí.",
    "Soy bueno(a) para el atletismo",
    "Me gusta trabajar con números y figuras",
    "me gustan pasar tiempo con los animales del campo",
    "Me gusta escribir cartas detalladas a mis amigos.",
    "Me gusta entretenerme con juegos electrónicos"
];

// Mapeo de preguntas a tipos de inteligencia
const questionMapping = {
    // Inteligencia A: Verbal/Lingüística
    "A": [9, 10, 22, 39],
    // Inteligencia B: Lógico/Matemática
    "B": [5, 7, 17, 20, 37],
    // Inteligencia C: Visual/Espacial
    "C": [1, 11, 14, 23, 27],
    // Inteligencia D: Kinestésica/Corporal
    "D": [8, 16, 19, 21, 36],
    // Inteligencia E: Musical/Rítmica
    "E": [3, 4, 13, 24, 28],
    // Inteligencia F: Intrapersonal
    "F": [2, 6, 26, 31, 33],
    // Inteligencia G: Interpersonal
    "G": [12, 18, 32, 34, 35],
    // Inteligencia H: Naturalista
    "H": [15, 25, 29, 30, 38, 40]
};

// Información sobre los tipos de inteligencia
const intelligenceInfo = {
    "A": {
        name: "Inteligencia Verbal/Lingüística",
        description: "Es la capacidad de utilizar las palabras efectivamente, la lectura y la memoria.",
        professions: ["Derecho", "Literatura", "Docencia", "Periodismo", "Comercio internacional"]
    },
    "B": {
        name: "Inteligencia Lógico/Matemática",
        description: "Se refiere a la capacidad de trabajar bien con los números y/o basarse en la lógica y el raciocinio.",
        professions: ["Ingenierías", "Matemáticos", "Científicos", "Financieros"]
    },
    "C": {
        name: "Inteligencia Visual/Espacial",
        description: "Esta es la inteligencia de las imágenes. Requiere de habilidad para visualizar imágenes mentalmente o para crearlas en alguna forma como área, profundidad y altura.",
        professions: ["Ingenierías", "Arquitectura", "Diseño", "Marina", "Diseño de interiores"]
    },
    "D": {
        name: "Inteligencia Kinestésica/Corporal",
        description: "Es la inteligencia de todo el cuerpo, así como la inteligencia de las manos (maquinista, costurera, carpintero, cirujano).",
        professions: ["Deportistas", "Bailarines", "Mimo", "Actor/Actriz", "Maquinistas", "Cirujanos", "Carpinteros", "Costureras"]
    },
    "E": {
        name: "Inteligencia Musical/Rítmica",
        description: "Se relaciona con la capacidad de cantar una tonada, recordar melodías, tener buen sentido del ritmo o simplemente disfrutar de un buen oído.",
        professions: ["Cantantes", "Compositores", "Críticos musicales", "Bailarines profesionales"]
    },
    "F": {
        name: "Inteligencia Intrapersonal",
        description: "Es esencialmente la inteligencia de la comprensión de sí mismo, de saber quién se es. Es la inteligencia de saber las debilidades y fortalezas de sí mismo.",
        professions: ["Todas las áreas del conocimiento"]
    },
    "G": {
        name: "Inteligencia Interpersonal",
        description: "Esta inteligencia tiene que ver con la capacidad de entender a otras personas y trabajar con ellas.",
        professions: ["Trabajo social", "Ciencias humanas", "Administración", "Psicología", "Terapia ocupacional", "Docencia"]
    },
    "H": {
        name: "Inteligencia Naturalista",
        description: "Es la inteligencia desarrollada por personas que les atrae la observación y estudio de la naturaleza, no solo las plantas y los animales, si no, también, los fenómenos de la misma.",
        professions: ["Biólogos", "Médicos", "Ingenieros ambientales"]
    }
};

// Variables de estado
let currentQuestion = 0;
let scores = {
    "A": 0, "B": 0, "C": 0, "D": 0, 
    "E": 0, "F": 0, "G": 0, "H": 0
};

// Inicializar el test
function initTest() {
    showQuestion();
}

// Mostrar la pregunta actual
function showQuestion() {
    document.getElementById('question-number').textContent = `Pregunta ${currentQuestion + 1} de ${questions.length}`;
    document.getElementById('question-text').textContent = questions[currentQuestion];
    
    // Actualizar barra de progreso
    const progressPercent = ((currentQuestion + 1) / questions.length) * 100;
    document.getElementById('progress-text').textContent = `Pregunta ${currentQuestion + 1}/${questions.length}`;
    document.getElementById('progress-percent').textContent = `${Math.round(progressPercent)}%`;
    document.querySelector('.progress-fill').style.width = `${progressPercent}%`;
}

// Procesar respuesta
function answerQuestion(answer) {
    // Si la respuesta es verdadera, sumar a las inteligencias correspondientes
    if (answer) {
        for (const intelligence in questionMapping) {
            if (questionMapping[intelligence].includes(currentQuestion + 1)) {
                scores[intelligence]++;
            }
        }
    }
    
    // Avanzar a la siguiente pregunta o mostrar resultados
    currentQuestion++;
    
    if (currentQuestion < questions.length) {
        showQuestion();
    } else {
        showResults();
    }
}

// Mostrar resultados
function showResults() {
    // Ocultar pregunta y mostrar resultados
    document.querySelector('.question-card').style.display = 'none';
    document.getElementById('results-container').style.display = 'block';
    
    // Encontrar la inteligencia dominante
    let dominantIntelligence = '';
    let maxScore = 0;
    
    for (const intelligence in scores) {
        if (scores[intelligence] > maxScore) {
            maxScore = scores[intelligence];
            dominantIntelligence = intelligence;
        }
    }
    
    // Mostrar puntajes
    const scoresContainer = document.getElementById('scores-container');
    scoresContainer.innerHTML = '';
    
    for (const intelligence in scores) {
        const score = scores[intelligence];
        const info = intelligenceInfo[intelligence];
        
        const card = document.createElement('div');
        card.className = `intelligence-card ${intelligence === dominantIntelligence ? 'primary' : ''}`;
        card.innerHTML = `
            <div class="intelligence-score">${score}</div>
            <div class="intelligence-name">${info.name}</div>
            <div class="intelligence-description">${info.description}</div>
        `;
        
        scoresContainer.appendChild(card);
    }
    
    // Mostrar inteligencia dominante
    const dominantInfo = intelligenceInfo[dominantIntelligence];
    document.getElementById('dominant-title').textContent = `Tu inteligencia dominante: ${dominantInfo.name}`;
    document.getElementById('dominant-description').textContent = dominantInfo.description;
    
    // Mostrar profesiones
    const professionsList = document.getElementById('professions-list');
    professionsList.innerHTML = '';
    
    dominantInfo.professions.forEach(profession => {
        const tag = document.createElement('div');
        tag.className = 'profession-tag';
        tag.textContent = profession;
        professionsList.appendChild(tag);
    });
}

// Reiniciar test
function restartTest() {
    currentQuestion = 0;
    scores = {
        "A": 0, "B": 0, "C": 0, "D": 0, 
        "E": 0, "F": 0, "G": 0, "H": 0
    };
    
    document.querySelector('.question-card').style.display = 'block';
    document.getElementById('results-container').style.display = 'none';
    
    showQuestion();
}

// Iniciar el test cuando se cargue la página
document.addEventListener('DOMContentLoaded', initTest);