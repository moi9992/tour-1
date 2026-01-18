<?php
require '../session/db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = (int) $_POST['id'];

    try {
        $sql = "DELETE FROM Enfants WHERE id = :id";
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();

        // Redirection après suppression
        header('Location: ../affichage/AffichageEnfant.php');
        exit;
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression : " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "Requête invalide ou ID manquant.";
}