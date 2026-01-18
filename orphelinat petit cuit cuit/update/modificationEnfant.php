<?php
$conn = mysqli_connect("localhost", "root", "", "cuitcuit");

if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Vérifier que l'id existe
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../affichage/AffichageEnfant.php");
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM Enfants WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header("Location: ../affichage/AffichageEnfant.php");
    exit;
}

if (isset($_POST['submit'])) {
    $id = intval($_POST['id']);
    $Nom = $_POST['Nom'];
    $Prenom = $_POST['Prenom'];
    $Sexe = $_POST['Sexe'];
    $Date_de_naissance = $_POST['Date_de_naissance'];
    $Taille = $_POST['Taille'];
    $Poids = $_POST['Poids'];
    $DateArriver = $_POST['DateArriver'];
    $Souvenirs = $_POST['Souvenirs'];

    // Requête de mise à jour corrigée
    $sql = "UPDATE Enfants SET Nom='$Nom', Prenom='$Prenom', Taille='$Taille', Sexe='$Sexe', Date_de_naissance='$Date_de_naissance', Poids='$Poids', DateArriver='$DateArriver', Souvenirs='$Souvenirs' WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: ../affichage/AffichageEnfant.php");
        exit;
    } else {
        echo "Erreur lors de la mise à jour : " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Enfant</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Modifier un Enfant</h2>

    <?php if (isset($row)) { ?>
        <div class="mod">
            <form method="POST" action="modificationEnfant.php?id=<?= $id ?>">
                <input type="hidden" name="id" value="<?= $row['id'] ?>" required><br>

                <label>Nom :</label>
                <input type="text" name="Nom" value="<?= htmlspecialchars($row['Nom']) ?>" required><br>

                <label>Prénom :</label>
                <input type="text" name="Prenom" value="<?= htmlspecialchars($row['Prenom']) ?>" required><br>

                <label>Sexe :</label>
                <select name="Sexe" required>
                    <option value="M" <?= $row['Sexe'] == 'M' ? 'selected' : '' ?>>M</option>
                    <option value="F" <?= $row['Sexe'] == 'F' ? 'selected' : '' ?>>F</option>
                    <option value="Autre" <?= $row['Sexe'] == 'Autre' ? 'selected' : '' ?>>Autre</option>
                </select><br>

                <label>Date de naissance :</label>
                <input type="date" name="Date_de_naissance" value="<?= htmlspecialchars($row['Date_de_naissance']) ?>" required><br>

                <label>Taille :</label>
                <input type="number" name="Taille" value="<?= htmlspecialchars($row['Taille']) ?>" required><br>

                <label>Poids :</label>
                <input type="number" step="0.1" name="Poids" value="<?= htmlspecialchars($row['Poids']) ?>" required><br>

                <label>Date d'arrivée :</label>
                <input type="date" name="DateArriver" value="<?= htmlspecialchars($row['DateArriver']) ?>" required><br>

                <label>Souvenirs :</label>
                <textarea name="Souvenirs" required><?= htmlspecialchars($row['Souvenirs']) ?></textarea><br>

                <input type="submit" name="submit" value="Mettre à jour" class="btn btn-primary">
                <button type="button" class="btn btn-secondary" onclick="window.location.href='../affichage/AffichageEnfant.php'">Annuler</button>
            </form>
        </div>
    <?php } else { ?> 
        <p style="color:red;">Aucun enfant sélectionné pour modification.</p>
    <?php } ?>
</body>
</html>