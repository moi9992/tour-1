<?php
require '../session/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Films - Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../headerFooter/header.php'; ?>

<div class="container main-content my-5">
  <div class="form-container border p-4 rounded bg-light shadow">
    <h2 class="mb-4 text-center">Connexion</h2>

    <?php 
    $message = '';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $identifiant = trim($_POST['identifiant']); // Email ou pseudo
        $mdp = $_POST['mdp'];

        if (!empty($identifiant) && !empty($mdp)) {

            // Cherche utilisateur par Email OU Pseudo
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE Email = :id OR Pseudo = :id");
            $stmt->execute(['id' => $identifiant]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($mdp, $user['Mdp'])) {

                // 🔥 CALCUL DE L'ÂGE
                $dob = new DateTime($user['DateDeNaissance']);
                $today = new DateTime();
                $age = $today->diff($dob)->y;

                // 🔥 STOCKAGE DANS LA SESSION
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'pseudo' => $user['Pseudo'],
                    'prenom' => $user['Prenom'],
                    'nom' => $user['Nom'],
                    'dateNaissance' => $user['DateDeNaissance'],
                    'age' => $age  // <-- Age dispo partout
                ];

                $_SESSION['isLog'] = true;

                header('Location: ../mainPages/index.php');
                exit;

            } else {
                $message = '<div class="alert alert-danger text-center mt-3">
                                ❌ Identifiants incorrects.
                            </div>';
            }
        } else {
            $message = '<div class="alert alert-warning text-center mt-3">
                            ⚠️ Remplis tous les champs.
                        </div>';
        }
    }
    ?>

    <form method="POST" action="">
      <div class="mb-3">
        <label for="identifiant" class="form-label">Email ou Pseudo</label>
        <input type="text" name="identifiant" id="identifiant" 
               class="form-control border-dark" placeholder="Entrer votre pseudo ou adresse mail" required>
      </div>

      <div class="mb-3">
        <label for="mdp" class="form-label">Mot de passe</label>
        <input type="password" name="mdp" id="mdp" 
               class="form-control border-dark" placeholder="Entrer votre mot de passe" required>
      </div>

      <div class="d-grid col-6 mx-auto mt-4">
        <button type="submit" class="btn btn-primary">Connexion</button>
        <a href="inscription.php" class="btn btn-secondary mt-2">Créer un compte</a>
      </div>
    </form>

    <?= $message ?>
  </div>
</div>

<?php include '../headerFooter/footer.php'; ?>
</body>
</html>
