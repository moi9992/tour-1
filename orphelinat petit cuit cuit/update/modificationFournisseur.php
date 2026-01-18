<?php

require '../session/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../affichage/AffichageFournisseur.php");
    exit;
}

$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM Fournisseurs WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    header("Location: ../affichage/AffichageFournisseur.php");
    exit;
}

if (isset($_POST['submit'])) {
    $id = intval($_POST['id']);
    $Nom = $_POST['Nom'];
    $Ville = $_POST['Ville'];
    $Telephone = $_POST['Telephone'];
    $Email = $_POST['Email'];
    $Notes = $_POST['Notes'];

        $stmt = $pdo->prepare('SELECT COUNT(*) FROM Fournisseurs WHERE Telephone = ? or Email = ?');
        $stmt->execute([$Telephone, $Email]);
        $userExists = $stmt->fetchColumn();

    if ($userExists > 1) {
        header("Location: modificationFournisseur.php?id=$id&status=email_exists");
        exit;
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE Fournisseurs SET Nom = ?, Ville = ?, Telephone = ?, Email = ?, Notes = ? WHERE id = ?");
            $stmt->execute([$Nom, $Ville, $Telephone, $Email, $Notes, $id]);
            header("Location: ../affichage/AffichageFournisseur.php?status=success");
            exit;
        } catch (PDOException $e) {
            echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
            header("Location: modificationFournisseur.php?id=$id&status=db_error");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Fournisseur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Modifier le fournisseur</h2>

    <?php 
    if (isset($_GET['status']) && $_GET['status'] === 'email_exists') {
        echo "<p style='color:red;'>Cette adresse e-mail ou ce téléphone est déjà utilisée par un autre fournisseur.</p>";
    }
    ?>

    <?php if (isset($row)) { ?>
        <div class= "mod">
    <form method="POST" action="modificationFournisseur.php?id=<?= $id ?>">
        <?php $id = isset($row['id']) ? $row['id'] : ''; ?>   
            <input type="hidden" name="id" value="<?= $id ?>" required><br>

        <label>Nom :</label>
            <?php $Nom = isset($row['Nom']) ? $row['Nom'] : ''; ?> 
            <input type="text" name="Nom" value="<?= $Nom ?>" required><br>

        <label>Ville :</label>
            <?php $Ville = isset($row['Ville']) ? $row['Ville'] : ''; ?> 
            <input type="text" name="Ville" value="<?= $Ville ?>" required><br>

        <label>Téléphone :</label>
            <?php $Telephone = isset($row['Telephone']) ? $row['Telephone'] : ''; ?>
            <input type="number" name="Telephone" value="<?= $row['Telephone'] ?>" required><br>

        <label>E-mail :</label>
            <?php $Email = isset($row['Email']) ? $row['Email'] : '' ; ?>
            <input type="text" name="Email" value="<?= $Email ?>" required><br>

        <label>Notes :</label>
            <?php $Notes = isset($row['Notes']) ? $row['Notes'] : ''; ?>
            <input type="text" name="Notes" value="<?= $Notes ?>" required><br>

         <input type="submit" name="submit" value="Mettre à jour" class="btn btn-primary">
        <button type="button" class="btn btn-secondary" onclick="window.location.href='../affichage/AffichageFournisseur.php'">Annuler</button>
    </form>
    </div>

     <?php } else { ?> 
        <p style="color:red;">Aucun fournisseur sélectionné pour modification.</p>
        <?php } ?>
</body>
</html>
