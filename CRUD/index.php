<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>CRUD</title>
</head>

<body>
<h1>Liste des users</h1>

<?php
  // Messages de succès ou d’erreur selon le paramètre dans l’URL
  // Si l’URL contient ?success=1 → l’ajout d’un utilisateur s’est bien déroulé
  if (isset($_GET['success']) && $_GET['success'] == 1) { // Si l’URL contient ?success=1 → l’ajout d’un utilisateur s’est bien déroulé
      echo "<p style='color:green; font-weight:bold;'>Utilisateur ajouté avec succès !</p>";
  }
  // Si l’URL contient un paramètre d’erreur, on identifie lequel afficher
  if (isset($_GET['error'])) {
      if ($_GET['error'] == 1) { //  Erreur n°1 → au moins un champ du formulaire est vide
          echo "<p style='color:red; font-weight:bold;'>Tous les champs sont obligatoires.</p>";
      } elseif ($_GET['error'] == 2) {  //  Erreur n°2 → problème lors de l’insertion dans la base de données
          echo "<p style='color:red; font-weight:bold;'>Erreur lors de l\’ajout dans la base de données.</p>";
      } elseif ($_GET['error'] == 3) { //  Erreur n°3 → tentative d’accès direct sans envoi du formulaire
          echo "<p style='color:red; font-weight:bold;'>Méthode d\’accès non autorisée.</p>";
      }
  }
  ?>

<form action="insert.php" method="POST">
    <input class="taille" type="text" name="nom" placeholder="Nom" required>
    <input class="taille" type="text" name="prenom" placeholder="Prenom" required>
    <input class="taille" type="text" name="age" placeholder="Age" required>
    <select class="taille" name="sexe">
        <option value="">Sexe</option>
        <option value="Homme">Homme</option>
        <option value="Femme">Femme</option>
        <option value="Autre">Autre</option>
    </select>
    <input class="taille" type="submit" value="Ajouter">
</form>
<?php

// Tentative de connexion à la base de données MySQL avec PDO
try {
    $bdd = new PDO("mysql:host=localhost;dbname=premiercrud", "root", "");
} catch(Exception $e) {
     // Si la connexion échoue, on arrête tout et on affiche un message d’erreur
    die('Erreur : ' . $e->getMessage());
}


// On exécute une requête SQL pour récupérer les informations des utilisateurs
// Ici on sélectionne les colonnes id, nom, prenom, age et sexe de la table "utilisateurs"
$reponse = $bdd->query('SELECT id, nom, prenom, age, sexe FROM utilisateurs');
?>


<table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Âge</th>
        <th>Sexe</th>
        <th>Supprimer / Modifier</th>

    </tr>

    <?php while ($utilisateur = $reponse->fetch()): ?>
        <tr>
            <td><?=$utilisateur['id'] ?></td>
            <td><?=$utilisateur['nom'] ?></td>
            <td><?=$utilisateur['prenom'] ?></td>
            <td><?=$utilisateur['age'] ?></td>
            <td><?=$utilisateur['sexe'] ?></td>
            <td>
                <div class = sup>
                <form action="delete.php" method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                    <input type="hidden" name="id" value="<?= $utilisateur['id'] ?>">
                    <input type="submit" name="supprimer" value="Supprimer" class="button">
                </form>
                <a href="modification.php?id=<?= $utilisateur['id'] ?>" onclick="return confirm('Modifier cet utilisateur ?');">
                    <input type="button" value="Modifier" class="button">
                </a>
                </div>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>