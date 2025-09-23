<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sinaptium/config.php';
include_once HOME_PATH . 'componentes/head_component.php';
?>
<!doctype html>
<html lang="es">
<head>
    <?php renderHead('Sinaptium - Orientación Vocacional'); ?>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        /* Estilos específicos para el test de orientación vocacional */
        .test-container {
            min-height: 80vh;
            display: flex;
            align-items: center;
            padding: 40px 0;
        }
        
        .question-card {
            background: var(--Sinaptium-card-bg);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid var(--Sinaptium-border);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .question-number {
            font-size: 0.9rem;
            color: var(--neuro-blue);
            margin-bottom: 10px;
        }
        
        .question-text {
            font-size: 1.2rem;
            margin-bottom: 25px;
            line-height: 1.6;
            color: white; /* Cambiado a blanco para mejor visibilidad */
        }
        
        .answer-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        
        .btn-answer {
            flex: 1;
            padding: 15px 20px;
            border-radius: 10px;
            font-weight: 600;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-true {
            background: linear-gradient(90deg, var(--neuro-green), #2e7d32);
            color: white;
        }
        
        .btn-false {
            background: linear-gradient(90deg, var(--neuro-orange), #ef6c00);
            color: white;
        }
        
        .btn-answer:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .progress-container {
            margin-bottom: 30px;
        }
        
        .progress-bar {
            height: 10px;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--neuro-blue), var(--neuro-purple));
            border-radius: 5px;
            transition: width 0.5s ease;
        }
        
        .results-container {
            display: none;
            padding: 30px;
            background: var(--Sinaptium-card-bg);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid var(--Sinaptium-border);
            margin-top: 20px;
        }
        
        .intelligence-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid;
            transition: all 0.3s ease;
            color: white; /* Asegurar texto blanco en las tarjetas */
        }
        
        .intelligence-card:hover {
            transform: translateX(5px);
        }
        
        .intelligence-card.primary {
            background: rgba(79, 195, 247, 0.15);
            border-left-color: var(--neuro-blue);
        }
        
        .intelligence-score {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: white;
        }
        
        .intelligence-name {
            font-weight: 600;
            margin-bottom: 10px;
            color: white;
        }
        
        .intelligence-description {
            font-size: 0.9rem;
            opacity: 0.8;
            color: white;
        }
        
        .dominant-intelligence {
            background: rgba(156, 39, 176, 0.15);
            padding: 30px;
            border-radius: 15px;
            margin: 30px 0;
            text-align: center;
            border: 1px solid var(--Sinaptium-border);
            color: white; /* Asegurar texto blanco */
        }
        
        .dominant-title {
            color: var(--neuro-purple);
            font-size: 1.8rem;
            margin-bottom: 15px;
        }
        
        .professions-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }
        
        .profession-tag {
            padding: 8px 15px;
            background: rgba(79, 195, 247, 0.2);
            border-radius: 50px;
            font-size: 0.9rem;
            color: white;
        }
        
        @media (max-width: 768px) {
            .answer-buttons {
                flex-direction: column;
            }
            
            .question-text {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <div class="neuronal-background"></div>
    
    <?php include '../componentes/navbar.php'; ?>
    
    <div class="container test-container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <h1 class="text-center mb-4" style="color: white;">Test de Orientación Vocacional</h1>
                <p class="text-center mb-5" style="color: white;">Responde Verdadero o Falso a cada afirmación según tu preferencia. Al final descubrirás tu tipo de inteligencia dominante y las profesiones que mejor se adaptan a ti.</p>
                
                <div class="progress-container">
                    <div class="d-flex justify-content-between mb-2">
                        <span id="progress-text" style="color: white;">Pregunta 1/40</span>
                        <span id="progress-percent" style="color: white;">2%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 2.5%;"></div>
                    </div>
                </div>
                
                <div class="question-card">
                    <div class="question-number" id="question-number">Pregunta 1 de 40</div>
                    <div class="question-text" id="question-text"></div>
                    <div class="answer-buttons">
                        <button class="btn-answer btn-true" onclick="answerQuestion(true)">Verdadero</button>
                        <button class="btn-answer btn-false" onclick="answerQuestion(false)">Falso</button>
                    </div>
                </div>
                
                <div class="results-container" id="results-container">
                    <h2 class="text-center mb-4" style="color: white;">Resultados de tu Test</h2>
                    
                    <div id="scores-container"></div>
                    
                    <div class="dominant-intelligence">
                        <h3 class="dominant-title" id="dominant-title"></h3>
                        <p id="dominant-description"></p>
                        <div class="professions-list" id="professions-list"></div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button class="btn-glow" onclick="restartTest()">Realizar Test Nuevamente</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-4 mt-5" data-aos="fade-up">
        <div class="container text-center">
            <p class="footer-text">© 2025 Sinaptium. Todos los derechos reservados.</p>
        </div>
    </footer>


    <script src="../js/voca.js"></script>
</body>
</html>