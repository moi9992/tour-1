<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>exoMerde</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="quiz-container">
        <h1>Quiz exoMerde</h1>
        
        <div class="filtres">
            <select id="theme" name="theme">
                <option value="">Tous les thèmes</option>
                <option value="jeux video">Jeux vidéo</option> 
                <option value="culture general">Culture générale</option>
                <option value="tv et cinema">TV et cinéma</option>
            </select>
            
            <select id="difficulte" name="difficulte">
                <option value="">Toutes difficultés</option>
                <option value="facile">Facile</option>
                <option value="normal">Normal</option>
                <option value="difficile">Difficile</option>
            </select>
            
            <button type="button" class="btn" id="nouvelle-question">Nouvelle question</button>
        </div>

        <div id="question-container">
            <p>Chargement de la question...</p>
        </div>
    </div>

    <script src="Js/script.js"></script>
</body>
</html>