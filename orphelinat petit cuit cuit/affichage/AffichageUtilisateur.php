<?php
require '../session/db.php'; 

$resultats = []; 
$recherche = '';

if (isset($_GET['recherche']) && $_GET['recherche'] !== '') {
    // Recherche spécifique
    $recherche = $_GET['recherche'];
    $stmt = $pdo->prepare("SELECT * FROM Utilisateurs WHERE login LIKE :recherche");
    $stmt->execute(['recherche' => $recherche . '%']);
    $resultats = $stmt->fetchAll();
} else {
    // Si recherche vide, afficher tous les fournisseurs
    $stmt = $pdo->query("SELECT * FROM Utilisateurs");
    $resultats = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> 
    <meta name="description" content="Utilisateurs">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
           <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-TLHRYtxFDLVLkxNT2E6HyKffUg6fS5NBfGG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="../styles/style.css">
    <title>Utilisateurs</title>
</head>
<!-- Barre de Navigation (Header) -->
<?php include '../headerFooter/header.php'; ?>
    <main class="main-content">
<body>
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
                } elseif ($status === 'Utilisateur_exist') {
                    $message = "⚠️ un utilisateur avec le meme nom ou mail existe déjà connard.";
                    $alertClass = 'warning'; // Jaune
                }
                
                // Afficher le message s'il existe
                if ($message) {
                    echo '<div class="alert alert-' . $alertClass . ' mt-3" role="alert">';
                    echo htmlspecialchars($message);
                    echo '</div>';
                }
            }
            ?>
        <div>
            <form action="../insert/insert.php" method="POST" class="form-container mt-3 mb-5 p-3 border border-2 border-dark rounded">
                <h2>Ajouter un Utilisateur</h2>
                <label for="login" class="form-label">Identifiant:</label>
                <input type="text" id="login" name="login" required class="form-control"><br><br>
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" id="email" name="email" required class="form-control"><br><br>
                <label for="password" class="form-label">Mot de passe:</label>
                <input type="password" id="password" name="password" required class="form-control"><br><br>
                <input type="submit" value="Ajouter" class="btn btn-primary">
            </form>
        </div>
    </div>

<form method="get" class="d-flex justify-content-center align-items-center mt-3">
    <input type="text" name="recherche" placeholder="Rechercher un Utilisateur" value="<?= ($recherche) ?>">
    <button type="submit">Rechercher</button>
</form>


<?php if (!empty($resultats)): ?>
    <table class="table table-bordered border-dark border border-2 my-4 p-1">
        <tr>
            <th class="text-light bg-dark text-center">ID</th>
            <th class="text-light bg-dark text-center">Identifiant</th>
            <th class="text-light bg-dark text-center">E-mail</th>
            <th class="text-light bg-dark text-center">Rôle</th>
            <th class="text-light bg-dark text-center">Date de création</th>
            <th class="text-light bg-dark text-center">Modifier Supprimer</th>
        </tr>
        <?php foreach ($resultats as $resultat): ?>
            <tr>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['id']) ?></td>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['login']) ?></td>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['email']) ?></td>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['role']) ?></td>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['created_at']) ?></td>
                <td>
                <div class = sup>                    
                            <form action="../delete/deleteUtilisateur.php" method="POST" onsubmit="return confirm('Supprimer ce fournisseurs ?');">                        
                            <input type="hidden" name="id" value="<?= $resultat['id'] ?>">                        
                            <input type="submit" name="supprimer" value="Supprimer" class="button">
                            </form>
                            <a href="../update/modificationUtilisateur.php?id=<?= $resultat['id'] ?>" onclick="return confirm('Modifier ce Fournisseur?');">
                                <input type="button" value="Modifier" class="button">
                            </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php elseif (!empty($recherche)): ?>
    <p class="message">Aucune utilisateur trouvée pour "<strong><?= htmlspecialchars($recherche) ?></strong>".</p>
<?php endif; ?>
</main>
<!-- Footer -->
<?php include '../headerFooter/footer.php'; ?>
</body>


</html>


