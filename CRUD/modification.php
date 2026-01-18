<?php

$conn = mysqli_connect("localhost", "root", "", "premiercrud"); // (1) Connexion à la base de données avec l’extension mysqli

if (!$conn) {
    // (2) Si la connexion échoue, on arrête le script et on affiche une erreur
    die("Erreur de connexion : " . mysqli_connect_error());
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    // (3) Si aucun ID n’est passé dans l’URL (ex: modification.php?id=3)
    // on redirige l’utilisateur vers la page d’accueil
    header("Location: index.php");
    exit;
}

$id = $_GET['id']; // (4) On récupère l’ID de l’utilisateur à modifier depuis l’URL
$sql = "SELECT * FROM utilisateurs WHERE id = $id"; // (5) Requête pour récupérer les infos de cet utilisateur
$result = mysqli_query($conn, $sql); // (6) Exécution de la requête SQL
$row = mysqli_fetch_assoc($result); // (7) On stocke les données récupérées dans un tableau associatif

if (!$row) {
     // (8) Si aucun utilisateur n’a été trouvé avec cet ID, on retourne sur index.php
    header("Location: index.php");
    exit;
}

if (isset($_POST['submit'])) {
    // (9) Si le formulaire de modification a été soumis...
    $id = $_POST['id']; // (10) On récupère l’ID de l’utilisateur
    $nom = $_POST['nom'];  // (11) On récupère le nom modifié
    $prenom = $_POST['prenom'];  // (12) Le prénom
    $age = $_POST['age']; // (13) L’âge
    $sexe = $_POST['sexe'];  // (14) Et le sexe

    $sql = "UPDATE utilisateurs SET nom='$nom', prenom='$prenom', age='$age', sexe='$sexe' WHERE id=$id";  // (15) Requête SQL pour mettre à jour les informations de l’utilisateur selon son ID
    $result = mysqli_query($conn, $sql); // (16) On exécute la requête SQL

    if ($result) {
         // (17) Si la mise à jour réussit, on retourne sur index.php
        header("Location: index.php");
        exit;
    } else {
        // (18) Sinon, on affiche une erreur
        echo "Erreur lors de la mise à jour : " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un utilisateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Modifier l'utilisateur</h2>

    <?php if (isset($row)) { ?>  <!-- (19) Si un utilisateur a bien été trouvé, on affiche le formulaire de modification -->

    <div class= mod>
    <form method="POST" action="modification.php">
        <?php $id = isset($row['id']) ? $row['id'] : ''; ?>   <!-- (20) On vérifie que l’ID existe avant de l’afficher dans un champ caché -->
            <input type="hidden" name="id" value="<?= $id ?>">

        <label>Nom :</label>
            <?php $nom = isset($row['nom']) ? $row['nom'] : ''; ?> 
            <input type="text" name="nom" value="<?= $nom ?>" required><br>
            <!-- (21) Champ texte pré-rempli avec le nom actuel -->

        <label>Prénom :</label>
            <?php $prenom = isset($row['prenom']) ? $row['prenom'] : ''; ?> 
            <input type="text" name="prenom" value="<?= $prenom ?>" required><br>
              <!-- (22) Champ texte pré-rempli avec le prénom -->

        <label>Âge :</label>
            <input type="number" name="age" value="<?= $row['age'] ?>" required><br>
            <!-- (23) Champ numérique pour l’âge -->

        <label>Sexe :</label>
        <select name="sexe" required>
            <?php $sexe = isset($row['sexe']) ? $row['sexe'] : ''; ?> 
            <option value="Homme" <?= $sexe === 'Homme' ? 'selected' : '' ?>>Homme</option>
            <option value="Femme" <?= $sexe === 'Femme' ? 'selected' : '' ?>>Femme</option>
            <option value="Autre" <?= $sexe === 'Autre' ? 'selected' : '' ?>>Autre</option>
        </select><br><br>
         <!-- (24) Menu déroulant avec la valeur actuelle sélectionnée -->

        <input type="submit" name="submit" value="Mettre à jour">  <!-- (25) Bouton pour valider la modification -->
    </form>
    </div>

     <?php } else { ?>  <!-- (26) Si aucun utilisateur n’est trouvé, on affiche un message d’erreur -->
        <p style="color:red;">Aucun utilisateur sélectionné pour modification.</p>
        <?php } ?>
</body>
</html>