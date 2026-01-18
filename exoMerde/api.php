<?php 
require 'db.php';

header('Content-Type: application/json'); // dis qu'on lui donne du json et pas du html normal 

$theme = isset($_GET['theme']) ? $_GET['theme'] : '';
$difficulte = isset($_GET['difficulte']) ? $_GET['difficulte'] : '';

$sql = "SELECT * FROM questions WHERE 1=1";
$params = [];

if (!empty($theme)) {
    $sql .= " AND theme = :theme";
    $params[':theme'] = $theme;
}

if (!empty($difficulte)) {
    $sql .= " AND difficulty = :difficulte";
    $params[':difficulte'] = $difficulte;
}

$sql .= " ORDER BY RAND() LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$question = $stmt->fetch(PDO::FETCH_ASSOC);

if ($question) {
    $reponses = [
        ['texte' => $question['bonne_reponse'], 'correcte' => true], // correcte = es ce que cest la bonne reponse la c'est vrai en dessous cest faux 
        ['texte' => $question['mauvaise_reponse1'], 'correcte' => false],
        ['texte' => $question['mauvaise_reponse2'], 'correcte' => false],
        ['texte' => $question['mauvaise_reponse3'], 'correcte' => false]
    ];
    shuffle($reponses);
    
    echo json_encode([
        'success' => true, // success = est ce que PHP a trouver une question dans la bdd ?
        'question' => $question['question'],
        'reponses' => $reponses 
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Aucune question disponible dans la base de données.'
    ]);
}
?>