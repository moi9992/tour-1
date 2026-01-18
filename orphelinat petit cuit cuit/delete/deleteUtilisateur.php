<?php
require '../session/db.php'; 
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = (int) $_POST['id'];

    if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
        $stmt = $pdo->prepare("SELECT role FROM Utilisateurs WHERE id = ?");
        $stmt->execute([$id]);
        $target_user = $stmt->fetch(PDO::FETCH_ASSOC); 

        if ($target_user && $target_user['role'] !== 'admin') { 
            try {

                $stmt = $pdo->prepare("DELETE FROM Utilisateurs WHERE id = ?");
                $stmt->execute([$id]);


                header('Location: ../affichage/affichageUtilisateur.php');
                exit;

            } catch (PDOException $e) {
                echo "Erreur lors de la suppression : " . htmlspecialchars($e->getMessage());
            }
        } else if ($target_user) {
            echo "Vous ne pouvez pas supprimer un administrateur.";
        } else {
            echo "Utilisateur introuvable.";
        }
    } else {
        echo "Vous n'avez pas les droits pour supprimer un utilisateur.";
    }
} else {
    echo "Requête invalide ou ID manquant.";
}