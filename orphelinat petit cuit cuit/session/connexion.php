<?php
require '../session/db.php'; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orphelinat au petit Cuit-cuit</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-TLHRYtxFDLVLkxNT2E6HyKffUg6fS5NBfGG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="../styles/style.css">
</head>
<body>

<!-- Barre de Navigation (Header) -->
<?php include '../headerFooter/header.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  try {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    $stmt = $pdo->prepare("SELECT * FROM Utilisateurs WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $utilisateur = $stmt->fetch();

    if ($utilisateur ){
      if (password_verify($mdp, $utilisateur['password'])) {
      $_SESSION['user'] = ['id' => $utilisateur['id'],'login' => $utilisateur['login'],'role' => $utilisateur['role']];
      $_SESSION['isLog'] = true;
      header('Location: ../mainPages/accueil.php');
      exit;
    } else {
      $message = '<div class="alert alert-danger text-center mt-3">Erreur : Mot de passe incorrect.</div>';
    }}
    else {
      $message = '<div class="alert alert-danger text-center mt-3">Erreur : Utilisateur non trouvé.</div>';
    }
  } catch (Exception $e) {
    $message = '<div class="alert alert-warning text-center mt-3">Erreur : ' .($e->getMessage()) . '</div>';
  }
}
?>

<div class="container main-content">
  <div class="form-container border p-4 rounded bg-light shadow">
    <h2 class="mb-4">Connexion</h2>
            
    <form method="POST" action="">
      <div class="mb-4">
        <label for="emailInput" class="form-label fs-5">E-mail</label>
        <input type="email" name="email" class="form-control form-control-lg border border-dark" id="emailInput" placeholder="Entrez votre e-mail" required>
      </div>

      <div class="mb-4">
        <label for="passwordInput" class="form-label fs-5">Mot de passe</label>
        <input type="password" name="mdp" class="form-control form-control-lg border border-dark" id="passwordInput" placeholder="Entrez votre mot de passe" required>
      </div>

      <div class="d-grid gap-2 col-6 mx-auto mt-4 btn-group-custom">
        <button type="submit" class="btn btn-primary object-fit-scale border rounded">Valider</button>
        <a href="inscription.php" class="btn btn-secondary object-fit-scale border rounded">S'inscrire</a>
      </div>
    </form>

    <?php if (!empty($message)): ?>
      <?= $message ?>
    <?php endif; ?>

  </div>
</div>

<!-- Footer -->
<?php include '../headerFooter/footer.php'; ?>
</body>
</html>