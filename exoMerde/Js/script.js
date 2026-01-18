document.addEventListener('DOMContentLoaded', function() {
    
const questionContainer = document.getElementById('question-container');
const btnNouvelle = document.getElementById('nouvelle-question');
const selectTheme = document.getElementById('theme');
const selectDifficulte = document.getElementById('difficulte');
    
    // Fonction pour charger une question via AJAX
    function chargerQuestion() {
        const theme = selectTheme.value;
        const difficulte = selectDifficulte.value;
        
        let url = 'api.php?';
        if (theme) url += 'theme=' + encodeURIComponent(theme) + '&';
        if (difficulte) url += 'difficulte=' + encodeURIComponent(difficulte);
        
        questionContainer.innerHTML = '<p>Chargement...</p>';
        
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur HTTP: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    afficherQuestion(data);
                } else {
                    questionContainer.innerHTML = '<p>' + data.message + '</p>';
                }
            })
            .catch(error => {
                console.error('ERREUR:', error);
                questionContainer.innerHTML = '<p>Erreur: ' + error.message + '</p>';
            });
    }
    
    function afficherQuestion(data) {
        let html = '<div class="question-box">';
        html += '<h2 class="question">' + escapeHtml(data.question) + '</h2>';
        html += '<div class="reponses">';
        
        data.reponses.forEach(reponse => {
            html += '<button class="btn-reponse" data-correcte="' + (reponse.correcte ? '1' : '0') + '">';
            html += escapeHtml(reponse.texte);
            html += '</button>';
        });
        
        html += '</div>';
        html += '<div id="resultat"></div>';
        html += '</div>';
        
        questionContainer.innerHTML = html;
        attacherEvenementsReponses();
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function attacherEvenementsReponses() {
        const btnReponses = document.querySelectorAll('.btn-reponse');
        const resultatDiv = document.getElementById('resultat');
        
        btnReponses.forEach(btn => {
            btn.addEventListener('click', function() {
                btnReponses.forEach(b => b.disabled = true);
                
                const estCorrecte = this.dataset.correcte === '1';
                
                if (estCorrecte) {
                    this.classList.add('correcte');
                    resultatDiv.innerHTML = '<p class="succes">Gagner</p>';
                } else {
                    this.classList.add('incorrecte');
                    btnReponses.forEach(b => {
                        if (b.dataset.correcte === '1') {
                            b.classList.add('correcte');
                        }
                    });
                    resultatDiv.innerHTML = '<p class="erreur">Perdu </p>';
                }
            });
        });
    }
    
    btnNouvelle.addEventListener('click', chargerQuestion);
    selectTheme.addEventListener('change', chargerQuestion);
    selectDifficulte.addEventListener('change', chargerQuestion);
    
    chargerQuestion();
});