<?php
require '../session/db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $Nom = $_POST['Nom'] ?? '';
    $Prenom = $_POST['Prenom'] ?? '';
    $Sexe = $_POST['sexe'] ?? ''; 
    $Date_de_naissance = $_POST['Date_de_naissance'] ?? '';
    $Taille = $_POST['Taille'] ?? '';
    $Poids = $_POST['Poids'] ?? '';
    $DateArriver = $_POST['DateArriver'] ?? '';
    $Souvenirs = $_POST['Souvenirs'] ?? '';
    
    $fournisseurId = $_POST['fournisseur_id'] ?? ''; 

    if ($Souvenirs === '') {
        $Souvenirs = NULL;
    }
 
    if (!empty($Nom) && !empty($Prenom) && !empty($Sexe) && !empty($Date_de_naissance) && !empty($Taille) && !empty($Poids) && !empty($DateArriver) && !empty($fournisseurId)) {

        try {
            // Démarrer une transaction pour garantir les deux insertions
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("
                INSERT INTO enfants (Nom, Prenom, Sexe, Date_de_naissance, Taille, Poids, DateArriver, Souvenirs) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$Nom, $Prenom, $Sexe, $Date_de_naissance, $Taille, $Poids, $DateArriver, $Souvenirs]);

            // 2. Récupérer l'ID de l'enfant nouvellement inséré
            $enfantId = $pdo->lastInsertId();

            $stmtLiaison = $pdo->prepare("
                INSERT INTO enfants_fournisseur (child_id, school_id, since_date)
                VALUES (?, ?, NOW())
            ");
            $stmtLiaison->execute([$enfantId, $fournisseurId]);
            
            //  Valider la transaction
            $pdo->commit();

            header('Location: ../affichage/AffichageEnfant.php?status=success');
            exit;

        } catch (PDOException $e) {

            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            
            error_log("Erreur PDO lors de l'insertion de l'enfant/liaison: " . $e->getMessage());


            header('Location: ../affichage/AffichageEnfant.php?status=db_error');
            exit;
        }
    } else {

        header('Location: ../affichage/AffichageEnfant.php?status=missing_fields');
        exit;
    }
} else {
    echo "<p style='color:red;'>Méthode non autorisée.</p>";
}
?>