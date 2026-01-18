<?php
require '../session/db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Nom = $_POST['Nom'];
    $Ville = $_POST['Ville'];
    $Telephone = $_POST['Telephone'];
    $Email = $_POST['Email'];
    $Notes = $_POST['Notes'];

    if (!empty($Nom) && !empty($Ville) && !empty($Telephone) && !empty($Email) && !empty($Notes)) {

        $stmt = $pdo->prepare('SELECT COUNT(*) FROM Fournisseurs WHERE Nom = ? or Telephone = ? or Email = ?');
        $stmt->execute([$Nom, $Telephone, $Email]);
        $userExists = $stmt->fetchColumn();

        if ($userExists > 0) {
            header('Location: ../affichage/AffichageFournisseur.php?status=fournisseur_exist');
            exit;
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO Fournisseurs (Nom, Ville, Telephone, Email, Notes) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$Nom, $Ville, $Telephone, $Email, $Notes]);

                header('Location: ../affichage/AffichageFournisseur.php?status=success');
                exit;

            } catch (PDOException $e) {
                echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
                header('Location: ../affichage/AffichageFournisseur.php?status=db_error');
                exit;
            }
        }
    } else {
        // Champs manquants
        header('Location: ../affichage/AffichageFournisseur.php?status=missing_fields');
        exit;
    }
} else {
    echo "<p style='color:red;'>Méthode non autorisée.</p>";
}
?>