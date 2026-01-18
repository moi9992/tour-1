<?php

$db_host = 'localhost';             
$db_name = 'exoFetch';     
$db_user = 'root';  
$db_pass = ''; 
$table_name = 'sylabes'; 

$syllabes = [
    "la","ri","mon","ta","zo","na","li","do","re","mi",
    "sa","ko","chi","ra","no","lu","fa","ne","to","ru",
    "an","el","ma","so","ti","vi","ga","pe","lo","ni"
];

$resultats = [];
$message_status = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nombre_de_paires = max(1, (int)$_POST['nombre_paires']);
    $syllabes_par_mot = max(1, (int)$_POST['nombre_syllabes']);

    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $message_status = "<h3>❌ Erreur de connexion à la BDD : </h3>" . htmlspecialchars($e->getMessage());
        return; 
    }

    $stmt = $pdo->prepare("INSERT INTO $table_name (Nom, Prenom) VALUES (?, ?)");

    $insertions_reussies = 0;
    for ($i = 0; $i < $nombre_de_paires; $i++) {
        
        $prenom_genere = "";
        for ($j = 0; $j < $syllabes_par_mot; $j++) {
            $prenom_genere .= $syllabes[array_rand($syllabes)];
        }
        $prenom_formate = ($prenom_genere);

        $nom_genere = "";
        for ($j = 0; $j < $syllabes_par_mot; $j++) {
            $nom_genere .= $syllabes[array_rand($syllabes)];
        }
        $nom_formate = ($nom_genere);

        $paire = "{$prenom_formate} {$nom_formate}";

        try {
            $stmt->execute([$nom_formate, $prenom_formate]); 
            $resultats[] = $paire;
            $insertions_reussies++;
        } catch (PDOException $e) {
            $resultats[] = "ERREUR : " . $paire . " (Non inséré)";
        }
    }
    
    $message_status = "<h3>✅ Succès !</h3><p>{$insertions_reussies} couples Nom/Prénom ont été insérés dans la table <b>{$table_name}</b>.</p>";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syllabes</title>
</head>
<body>
    <h1>Noms & Prénoms Aléatoires</h1>
    
    <?php echo $message_status; ?>

    <form method="POST" action="">
        
        <label for="nombre_paires">Nombre de Nom/Prénom à générer</label>
        <input type="number" id="nombre_paires" name="nombre_paires" 
               placeholder="Entrez le nombre de Nom/Prénom a générer" min="1" required>
        
        <br><br>
        
        <label for="nombre_syllabes">Nombre de syllabes par mot :</label>
        <input type="number" id="nombre_syllabes" name="nombre_syllabes" 
               placeholder="Nombre de syllabes" min="1" required>
        
        <br><br>
        
        <button type="submit">Générer</button>
    </form>
    
    <hr>

    <h2>Résultats Insérés :</h2>
    
    <?php if (!empty($resultats)): ?>
        <p>Voici les <?php echo count($resultats); ?>Nom/Prénom insérés :</p>
        <ul>
            <?php foreach ($resultats as $paire): ?>
                <li><?php echo htmlspecialchars($paire); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Entrez les paramètres et cliquez sur le bouton pour commencer la génération.</p>
    <?php endif; ?>
    
</body>
</html>