<?php
require 'db.php'; // (1) On inclut le fichier db.php pour établir la connexion à la base de données via la variable $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {   // (2) On vérifie que le formulaire a bien été envoyé en méthode POST (pas en GET)

    // (3) On vérifie que tous les champs du formulaire sont remplis (nom, prénom, âge et sexe)
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['age']) && !empty($_POST['sexe'])) {
        $nom = trim($_POST['nom']); // (4) On récupère le nom et on enlève les espaces inutiles avec trim()
        $prenom = trim($_POST['prenom']); // (5) Idem pour le prénom
        $age = $_POST['age']; // (6) On récupère l'âge tel quel
        $sexe = $_POST['sexe']; // (7) On récupère le sexe sélectionné dans le menu déroulant

        try { // (8) On essaye d'exécuter la requête SQL d’insertion dans la base de données
            $sql = "INSERT INTO utilisateurs (nom, prenom, age, sexe) VALUES (?, ?, ?, ?)";
            // (9) Requête SQL préparée pour insérer un nouvel utilisateur dans la table "utilisateurs"
            // Les "?" sont des marqueurs pour éviter les erreurs et protéger les données
            $stmt = $pdo->prepare($sql); // (10) On prépare la requête pour exécution
            $stmt->execute([$nom, $prenom, $age, $sexe]); // (11) On exécute la requête avec les valeurs récupérées du formulaire

            header("Location: index.php?success=1"); // (12)  Redirige vers index.php avec un paramètre de succès
            exit; // (13) On arrête le script pour éviter que du code s’exécute après la redirection

        } catch (PDOException $e) { // (14) En cas d’erreur SQL, redirige vers index.php avec un code d’erreur 2
           header("Location: index.php?error=2");
            exit;

        }
    } else {
         // (16) Si un ou plusieurs champs sont vides, redirige avec un message d’erreur (code 1)
        header("Location: index.php?error=1");
        exit;
    }
} else {
    // (17) Si la page est appelée sans formulaire (ex: via URL directe), redirige avec un message d’erreur (code 3)
    header("Location: index.php?error=3");
    exit;
}


?>