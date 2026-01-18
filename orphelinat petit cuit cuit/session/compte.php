<?php
require '../session/db.php'; 

session_start();
if (!$_SESSION['isLog']) {
    header('Location: connexion.php');
    exit;
}

$userId = $_SESSION['user']['id'];
$message = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $email = $_POST['email'];
    $mdp = $_POST['password'];

    if ($login && $email && $mdp) {
        try {
            $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE Utilisateurs SET login = ?, email = ?, password = ? WHERE id = ?");
            $stmt->execute([$login, $email, $hashedPassword, $userId]);
            $message = "<div class='alert alert-success text-center'>Mise à jour réussie !</div>";
        } catch (PDOException $e) {
            $message = "<div class='alert alert-danger text-center'>Erreur : " . $e->getMessage() . "</div>";
        }
    } else {
        $message = "<div class='alert alert-warning text-center'>Veuillez remplir tous les champs.</div>";
    }
}

// Récupération des données utilisateur
try {
  $stmt = $pdo->prepare("SELECT * FROM Utilisateurs WHERE id = ?");
  $stmt->execute([$userId]);
  $utilisateur = $stmt->fetch();

  if (!$utilisateur) {
    header('Location: ../mainPages/accueil.php?status=notfound');
    exit;
  }
} catch (PDOException $e) {
    $message = "<div class='alert alert-danger text-center'>Erreur de lecture : " . $e->getMessage() . "</div>";
    $utilisateur = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"> 
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>

<!-- Barre de Navigation -->
<nav class="navbar navbar-expand-lg header-footer-dark px-3">
    <div class="container-fluid d-flex justify-content-between align-items-center px-4">
        <a class="navbar-brand text-white">Orphelinat au petit Cuit-cuit</a>
        <div class="d-flex align-items-center">
            <a class="nav-link text-light me-3" href="../mainPages/accueil.php">Accueil</a>
            <a class="nav-link text-light me-3" href="../mainPages/orphelinat.php">Orphelinat</a>
            <a class="nav-link text-light me-3" href="../mainPages/restaurant.php">Restaurant</a>
            <a href="logout.php" class="btn btn-danger ms-2">Déconnexion</a>
        </div>
    </div>
</nav>

<!-- Formulaire Mon Compte -->
<div class="container main-content mt-5">
    <div class="form-container border p-4 rounded bg-light shadow">
        <h2 class="mb-4 text-center">Mon Compte</h2>

        <?= $message ?>

        <form method="POST" action="">
            <div class="mb-4">
                <label for="login" class="form-label fs-5">Identifiant</label>
                <input name="login" type="text" class="form-control form-control-lg border border-dark" value="<?= $utilisateur['login'] ?>" required>
            </div>

            <div class="mb-4">
                <label for="email" class="form-label fs-5">E-mail</label>
                <input name="email" type="email" class="form-control form-control-lg border border-dark" value="<?= $utilisateur['email'] ?>" required>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fs-5">Nouveau mot de passe</label>
                <input name="password" type="password" class="form-control form-control-lg border border-dark" placeholder="Entrez un nouveau mot de passe" required>
            </div>

            <div class="d-flex flex-column align-items-center gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-lg w-100" style="max-width: 200px;">Valider</button>
                <a href="../delete/delete.php" class="btn btn-danger w-100" style="max-width: 200px;">Supprimer le compte</a>
            </div>
        </form>
    </div>
</div>

<!-- Footer -->
<?php include '../headerFooter/footer.php'; ?>

</body>
</html>