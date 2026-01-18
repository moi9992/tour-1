<?php
require '../session/db.php'; 

$resultats = [];
$recherche = '';


// Récupérer la liste de tous les fournisseurs pour le formulaire
$stmtFournisseurs = $pdo->query("SELECT id, Nom FROM fournisseurs ORDER BY Nom");
$fournisseurs_liste = $stmtFournisseurs->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['recherche']) && $_GET['recherche'] !== '') {
    $recherche = trim($_GET['recherche']);
    $stmt = $pdo->prepare("
        SELECT e.*, f.Nom AS Fournisseur_Nom
        FROM enfants e
        LEFT JOIN enfants_fournisseurs ef ON ef.child_id = e.id
        LEFT JOIN fournisseurs f ON f.id = ef.school_id /* school_id est l'ID du fournisseur */
        WHERE e.Nom LIKE :recherche
        ORDER BY e.Nom
    ");
    $stmt->execute(['recherche' => $recherche . '%']);
    $resultats = $stmt->fetchAll();
} else {
    $stmt = $pdo->query("
        SELECT e.*, f.Nom AS Fournisseur_Nom
        FROM enfants e
        LEFT JOIN enfants_fournisseurs ef ON ef.child_id = e.id
        LEFT JOIN fournisseurs f ON f.id = ef.school_id /* school_id est l'ID du fournisseur */
        ORDER BY e.Nom
    ");
    $resultats = $stmt->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> 
    <meta name="description" content="Enfants">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Enfants disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"> 
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>

<?php include '../headerFooter/header.php'; ?>
    <main class="main-content">
      <div>
        <h1>Formulaire d'inscription</h1>
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
            <form action="../insert/insertEnfant.php" method="POST" class="form-container mt-3 mb-5 p-3 border border-2 border-dark rounded ">
                <label for="Nom" class="form-label">Nom:</label>
                <input type="text" id="Nom" name="Nom" class="form-control">  
                <label for="Prenom" class="form-label">Prénom:</label>
                <input type="text" id="Prenom" name="Prenom" class="form-control">
                <label for="Sexe" class="form-label">Sexe:</label>
                <select id="Sexe" name="sexe" class="form-control">
                    <option value=""></option>
                    <option value="H">Homme</option>
                    <option value="F">Femme</option>
                    <option value="Autre">Autre</option>
                </select>
                <label for="Date_de_naissance" class="form-label">Date de naissance:</label>
                <input type="date" id="Date_de_naissance" name="Date_de_naissance" class="form-control">
                <label for="Taille" class="form-label">Taille (cm):</label>
                <input type="number" id="Taille" name="Taille" class="form-control">
                <label for="Poids" class="form-label">Poids (kg):</label>
                <input type="number" id="Poids" name="Poids" class="form-control">
                <label for="DateArriver" class="form-label">Date d'arrivée:</label>
                <input type="date" id="DateArriver" name="DateArriver"  class="form-control">
                <label for="Souvenirs" class="form-label">Souvenirs:</label>
                <input type="text" id="Souvenirs" name="Souvenirs" class="form-control">
                
                <label for="fournisseur_id" class="form-label">Fournisseur:</label>
                <select id="fournisseur_id" name="fournisseur_id" class="form-control">
                    <option value=""></option>
                    <?php foreach ($fournisseurs_liste as $fournisseur): ?>
                        <option value="<?= htmlspecialchars($fournisseur['id']) ?>">
                            <?= htmlspecialchars($fournisseur['Nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <input type="submit" value="Ajouter" class="btn btn-primary">
            </form>
        </div>
    </div>

<form method="get" class="d-flex justify-content-center align-items-center mt-3">
    <input type="text" name="recherche" placeholder="Rechercher un Enfant" value="<?= ($recherche) ?>">
    <button type="submit">Rechercher</button>
</form>

<?php if (!empty($resultats)): ?>
    <table class="table table-bordered border-dark border border-2 my-4 p-1">
        <tr>
            <th class="text-light bg-dark text-center">Nom_enfant</th>
            <th class="text-light bg-dark text-center">Prénom_enfant</th>
            <th class="text-light bg-dark text-center">Sexe</th>
            <th class="text-light bg-dark text-center">Date_de_naissance</th>
            <th class="text-light bg-dark text-center">Taille</th>
            <th class="text-light bg-dark text-center">Poids</th>
            <th class="text-light bg-dark text-center">Date_d'arrrivé</th>
            <th class="text-light bg-dark text-center">Souvenir</th>
            <th class="text-light bg-dark text-center">Fournisseur</th>
            <th class="text-light bg-dark text-center">Modifier Supprimer</th>
        </tr>

            <?php foreach ($resultats as $resultat): ?>
            <tr>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['Nom']) ?></td>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['Prenom']) ?></td>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['Sexe']) ?></td>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['Date_de_naissance']) ?></td>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['Taille']) ?></td>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['Poids']) ?></td>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['DateArriver']) ?></td>
                <td class="text-dark bg-white text-center"><?= htmlspecialchars($resultat['Souvenirs']) ?></td>
                
                <td class="text-dark bg-white text-center">
                    <?= htmlspecialchars($resultat['Fournisseur_Nom'] ?? '—') ?>
                </td>
                
                <td>   
                    <div class = sup>                    
                        <form action="../delete/deleteEnfant.php" method="POST" onsubmit="return confirm('Supprimer ce fournisseurs ?');">                        
                            <input type="hidden" name="id" value="<?= $resultat['id'] ?>">                        
                            <input type="submit" name="supprimer" value="Supprimer" class="button">
                        </form>
                        <a href="../update/modificationEnfant.php?id=<?= $resultat['id'] ?>" onclick="return confirm('Modifier ce Fournisseur?');">
                            <input type="button" value="Modifier" class="button">
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php elseif (!empty($recherche)): ?>
    <p class="message">Aucune enfant trouvée pour "<strong><?= htmlspecialchars($recherche) ?></strong>".</p>
<?php endif; ?>
    </main>
<?php include '../headerFooter/footer.php'; ?>
</body>
</html>