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
<?php include '../headerFooter/header.php'; ?>
    <div class="container main-content">
        <div class="form-container border p-4 rounded bg-light shadow">
            <h2 class="mb-4">Inscription</h2>
                    <?php 
            if (isset($_GET['status'])) {
                $status = $_GET['status'];
                $message = '';
                $alertClass = 'info';
                
                if ($status === 'success') {
                    $message = "✅ L'utilisateur a été ajouté avec succès ! Bravo tu n'es pas une p'tite merde.";
                    $alertClass = 'success'; // Vert
                } elseif ($status === 'db_error') {
                    $message = "❌ Erreur lors de l'ajout dans la base de données.";
                    $alertClass = 'danger'; // Rouge
                } elseif ($status === 'missing_fields') {
                    $message = "⚠️ faut remplir tous les champs p'tite merde.";
                    $alertClass = 'warning'; // Jaune
                } elseif ($status === 'utilisateur_exist') {
                    $message = "❌  email ou identifiant est déjà associé à un compte. Veuillez vous connecter ou utiliser un autre email p'tite merde";
                    $alertClass = 'danger'; // Rouge
                }
                
                // Afficher le message s'il existe
                if ($message) {
                    echo '<div class="alert alert-' . $alertClass . ' mt-3" role="alert">';
                    echo htmlspecialchars($message);
                    echo '</div>';
                }
            }
            ?>
            <form action="../insert/insert.php" method="POST">
              <div class="mb-4">
                  <label for="login" class="form-label fs-5">Identifiant</label>
                  <input name="login" placeholder="Identifiant" type="text" class="form-control form-control-lg border border-dark" required>
              </div>

              <div class="mb-4">
                  <label for="email" class="form-label fs-5">E-mail</label>
                  <input name="email" placeholder="E-mail" type="email" class="form-control form-control-lg border border-dark" required>
              </div>

              <div class="mb-4">
                  <label for="password" class="form-label fs-5">Mot de passe</label>
                  <input name="password" placeholder="Mot de passe" type="password" class="form-control form-control-lg border border-dark" required>
              </div>

              <div class="d-grid gap-2 col-6 mx-auto mt-4 btn-group-custom">
                <button type="submit" class="btn btn-primary object-fit-scale border rounded">Valider</button>
              </div>
          </form>
        </div>
    </div>


<!-- Footer -->
<?php include '../headerFooter/footer.php'; ?>
</body>
</html>