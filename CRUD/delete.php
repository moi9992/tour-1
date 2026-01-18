<?php
require_once('db.php');   // (1) On importe la connexion PDO depuis db.php pour accéder à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // (2) On vérifie que la requête vient bien d’un formulaire (méthode POST)
    //     et que le champ 'id' a bien été envoyé (l'utilisateur à supprimer)
    $id = (int) $_POST['id'];   // (3) On récupère l'ID envoyé par le formulaire et on le convertit en entier (sécurité + garantie que c’est bien un nombre)

    try { // (4) On essaye d'exécuter la suppression dans la base
        $sql = "DELETE FROM utilisateurs WHERE id = :id";   // (5) Requête SQL pour supprimer un utilisateur précis selon son ID
        $query = $pdo->prepare($sql); // (6) On prépare la requête pour éviter les injections SQL
        $query->bindValue(':id', $id, PDO::PARAM_INT); // (7) On remplace le marqueur ":id" par la vraie valeur d'ID (type entier)
        $query->execute(); // (8) On exécute la requête → l'utilisateur est supprimé de la base

        $pdo->exec("SET @count = 0");
        // (9) On crée une variable MySQL temporaire @count = 0
        // Elle servira à renuméroter les ID des utilisateurs restants
        $pdo->exec("UPDATE Utilisateurs SET id = @count := @count + 1");
        // (10) On renumérote tous les ID dans la table utilisateurs à partir de 1
        // Exemple : si les ID étaient 1,2,5,7 → ils deviendront 1,2,3,4

        $pdo->exec("ALTER TABLE Utilisateurs AUTO_INCREMENT = 1");
        // (11) On remet le compteur d’auto-incrémentation à 1
        // Ainsi, le prochain utilisateur ajouté prendra l'ID suivant disponible

        header('Location: index.php');  // (12) Une fois la suppression terminée, on redirige vers la page principale
        exit; // (13) On arrête l'exécution du script
    } catch (PDOException $e) { // (14) Si une erreur survient pendant la suppression, on affiche un message explicite
        echo "Erreur lors de la suppression : " . htmlspecialchars($e->getMessage());
    }
} else {
    // (15) Si la requête ne contient pas d'ID ou n’a pas été envoyée en POST,
    // on affiche un message d’erreur
    echo "Requête invalide ou ID manquant.";
}