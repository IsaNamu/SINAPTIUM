document.addEventListener('DOMContentLoaded', function() {
    const learningStyleTestForm = document.getElementById('learningStyleTest');

    learningStyleTestForm.addEventListener('submit', function(event) {
        event.preventDefault();

        // Calcular estilo predominante
        let userScores = { visual: 0, auditivo: 0, kinestesico: 0 };
        const totalQuestions = document.querySelectorAll('[class*="question-card"]').length;
        
        for (let i = 0; i < totalQuestions; i++) {
            const selectedOption = document.querySelector(`input[name="question${i}"]:checked`);
            if (selectedOption) userScores[selectedOption.value]++;
        }

        // Encontrar estilo con más votos
        let detectedStyle = Object.keys(userScores).reduce((a, b) => 
            userScores[a] > userScores[b] ? a : b
        );

        // Mostrar resultado
        document.getElementById('detectedStyle').textContent = 
            detectedStyle.charAt(0).toUpperCase() + detectedStyle.slice(1);
        document.getElementById('testResult').style.display = 'block';

        // Enviar al servidor
        fetch('controlador.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `tipoAprendizaje=${encodeURIComponent(detectedStyle)}`
        })
        .then(response => response.json())
        .then(data => {
            console.log('Respuesta:', data);
            if (data.success) {
                // Actualizar la sesión del cliente redirigiendo para refrescar
                setTimeout(() => {
                    window.location.href = `sociales_${detectedStyle}.php`;
                }, 2000);
            } else {
                console.error('Error:', data.message);
                setTimeout(() => {
                    window.location.href = `sociales.php`;
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setTimeout(() => {
                window.location.href = `sociales.php`;
            }, 2000);
        });
    });
});