<?php
require '../session/db.php'; 

$resultats = []; 
$recherche = '';

if (isset($_GET['recherche']) && $_GET['recherche'] !== '') {
    $recherche = $_GET['recherche'];
    $stmt = $pdo->prepare("SELECT * FROM Fournisseurs WHERE Nom LIKE :recherche");
    $stmt->execute(['recherche' => $recherche . '%']);
    $resultats = $stmt->fetchAll();
} else {
    $stmt = $pdo->query("SELECT * FROM Fournisseurs");
    $resultats = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> 
    <meta name="description" content="Fournisseurs">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fournisseurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-TLHRYtxFDLVLkxNT2E6HyKffUg6fS5NBfGG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>

<!-- Barre de Navigation (Header) -->
<?php include '../headerFooter/header.php'; ?>
    <main class="main-content">
<body>
      <div>
        <h1>Formulaire d'inscription</h1>
        <?php 
            if (isset($_GET['status'])) {
                $status = $_GET['status'];
                $message = '';
                $alertClass = 'info';
                
                if ($status === 'success') {
                    $message = "✅ Le fournisseur a été ajouté avec succès ! Bravo tu n'es pas une p'tite merde.";
                    $alertClass = 'success'; // Vert
                } elseif ($status === 'db_error') {
                    $message = "❌ Erreur lors de l'ajout dans la base de données.";
                    $alertClass = 'danger'; // Rouge
                } elseif ($status === 'missing_fields') {
                    $message = "⚠️ faut remplir tous les champs p'tite merde.";
                    $alertClass = 'warning'; // Jaune
                } elseif ($status === 'fournisseur_exist') {
                    $message = "⚠️ Un fournisseur avec ce numéro de téléphone, mail ou nom existe déjà.";
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
            <form action="../insert/insertFournisseur.php" method="POST" class="form-container mt-3 mb-5 p-3 border border-2 border-dark rounded" >
                <label for="Nom" class="form-label">Nom:</label>
                <input type="text" id="Nom" name="Nom" required class="form-control"><br><br>
                <label for="Ville" class="form-label">Ville:</label>
                <input type="text" id="Ville" name="Ville" required class="form-control"><br><br>
                <label for="Telephone" class="form-label">Téléphone:</label>
                <input type="text" id="Telephone" name="Telephone" required class="form-control"><br><br>
                <label for="Email" class="form-label">E-mail:</label>
                <input type="email" id="Email" name="Email" required class="form-control"><br><br>
                <label for="Notes" class="form-label">Notes:</label>
                <input type="text" id="Notes" name="Notes" required class="form-control"><br><br>
                <input type="submit" value="Ajouter le Fournisseur" class="btn btn-primary">
            </form>
        </div>
    </div>

<form method="get" class="d-flex justify-content-center align-items-center mt-3">
    <input type="text" name="recherche" placeholder="Rechercher un Fournisseur" value="<?= htmlspecialchars($recherche) ?>">
    <button type="submit">Rechercher</button>
</form>

<?php if (!empty($resultats)): ?>
    <table class="table table-bordered border-dark border border-2 my-4 p-1">
        <tr>
            <th class="text-light bg-dark text-center">Nom</th>
            <th class="text-light bg-dark text-center">Ville</th>
            <th class="text-light bg-dark text-center">Téléphone</th>
            <th class="text-light bg-dark text-center">E-mail</th>
            <th class="text-light bg-dark text-center">Notes</th>
            <th class="text-light bg-dark text-center">Modifier Supprimer</th>
        </tr>
        <?php foreach ($resultats as $resultat): ?>
            <tr>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['Nom']) ?></td>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['Ville']) ?></td>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['Telephone']) ?></td>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['Email']) ?></td>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['Notes']) ?></td>
                <td>   
                    <div class = sup>                    
                        <form action="../delete/deleteFournisseur.php" method="POST" onsubmit="return confirm('Supprimer ce fournisseurs ?');">                        
                            <input type="hidden" name="id" value="<?= $resultat['id'] ?>">                        
                            <input type="submit" name="supprimer" value="Supprimer" class="button">
                        </form>
                        <a href="../update/modificationFournisseur.php?id=<?= $resultat['id'] ?>" onclick="return confirm('Modifier ce Fournisseur?');">
                            <input type="button" value="Modifier" class="button">
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php elseif (!empty($recherche)): ?>
    <p class="message">Aucun fournisseur trouvé pour "<strong><?= htmlspecialchars($recherche) ?></strong>".</p>
<?php endif; ?>
</main>
<!-- Footer -->
<?php include '../headerFooter/footer.php'; ?>
</body>
</html>