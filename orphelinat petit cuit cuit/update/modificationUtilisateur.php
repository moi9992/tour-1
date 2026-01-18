<?php

require '../session/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../affichage/AffichageUtilisateur.php");
    exit;
}

$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM Utilisateurs WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    header("Location: ../affichage/AffichageUtilisateur.php");
    exit;
}

if (isset($_POST['submit'])) {
    $id = intval($_POST['id']);
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare('SELECT COUNT(*) FROM Utilisateurs WHERE email = ? OR login = ?');
        $stmt->execute([$email, $login]);
        $userExists = $stmt->fetchColumn();

    if ($userExists > 1) {
        header("Location: modificationUtilisateur.php?id=$id&status=email_exists");
        exit;
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE Utilisateurs SET login = ?, email = ?, password = ?, role = ? WHERE id = ?");
            $stmt->execute([$login, $email, $hashedPassword, $role, $id]);
            header("Location: ../affichage/AffichageUtilisateur.php?status=success");
            exit;
        } catch (PDOException $e) {
            echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
            header("Location: modificationUtilisateur.php?id=$id&status=db_error");
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
        echo "<p style='color:red;'>Cette adresse e-mail est déjà utilisée par un autre utilisateur.</p>";
    }
    ?>

    <?php if (isset($row)) { ?>
        <div class= "mod">
    <form method="POST" action="modificationUtilisateur.php?id=<?= $id ?>">
        <?php $id = isset($row['id']) ? $row['id'] : ''; ?>   
            <input type="hidden" name="id" value="<?= $id ?>" required><br>

        <label>Identifiant :</label>
            <?php $login = isset($row['login']) ? $row['login'] : ''; ?> 
            <input type="text" name="login" value="<?= $login ?>" required><br>

        <label>Email :</label>
            <?php $email = isset($row['email']) ? $row['email'] : ''; ?> 
            <input type="text" name="email" value="<?= $email ?>" required><br>

        <label>Rôle :</label>
            <?php $role = isset($row['role']) ? $row['role'] : '' ; ?>
            <input type="text" name="role" value="<?= $role ?>" required><br>
 
        <input type="submit" name="submit" value="Mettre à jour" class="btn btn-primary">
        <button type="button" class="btn btn-secondary" onclick="window.location.href='../affichage/AffichageUtilisateur.php'">Annuler</button>

    </form>
    </div>

     <?php } else { ?> 
        <p style="color:red;">Aucun utilisateur sélectionné pour modification.</p>
        <?php } ?>
</body>
</html>