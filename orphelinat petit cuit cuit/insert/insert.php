<?php
require '../session/db.php'; 
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($login) && !empty($email) && !empty($password)) {

        $stmt = $pdo->prepare('SELECT COUNT(*) FROM Utilisateurs WHERE email = ? OR login = ?');
        $stmt->execute([$email, $login]);
        $userExists = $stmt->fetchColumn();

        if ($userExists > 0) {
                if ($_SESSION['isLog']){
                header('Location: ../affichage/AffichageUtilisateur.php?status=Utilisateur_exist');
                exit;
                }
                else{
                    header('Location: ../session/AffichageUtilisateur.php?status=Utilisateur_exist');
                    exit;
                }
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO Utilisateurs (login, email, password, role) VALUES (?, ?, ?, ?)");
                $stmt->execute([$login,$email,password_hash($password, PASSWORD_DEFAULT),
                'user' // rôle par défaut
                ]);
                if ($_SESSION['isLog']){
                header('Location: ../affichage/AffichageUtilisateur.php?status=success');
                exit;
                }
                else{
                    header('Location: ../session/connexion.php?status=success');
                    exit;
                }

            } catch (PDOException $e) {
                echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
                header('Location: ../affichage/AffichageUtilisateur.php?status=db_error');
            }
            
        }
    } else {
        // Champs manquants
                        if ($_SESSION['isLog']){
                header('Location: ../affichage/AffichageUtilisateur.php?status=missing_fields');
                exit;
                }
                else{
                header('Location: ../session/inscription.php?status=missing_fields');
                exit;
                }
    }
} else {
    echo "<p style='color:red;'>Méthode non autorisée.</p>";
}
?>