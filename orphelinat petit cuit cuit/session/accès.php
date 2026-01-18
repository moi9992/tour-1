<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-TLHRYtxFDLVLkxNT2E6HyKffUg6fS5NBfGG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="../styles/style.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="background-color: rgba(32, 70, 27, 1);">

<?php include '../headerFooter/header.php'; ?>
<?php require '../session/db.php'; ?>

<?php

try {

    $stmt = $pdo->prepare("SELECT AVG(Taille) AS TailleMoyenne, AVG(Poids) AS PoidsMoyen, AVG(DATEDIFF(CURDATE(), Date_de_naissance) / 365.25) AS AgeMoyen FROM Enfants ");
    $stmt->execute();
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);


    $labels_chart = ['Taille Moyenne (cm)', 'Poids Moyen (kg)', 'Âge Moyen (ans)'];
    

    $taille = round($resultat['TailleMoyenne'] ?? 0, 2);
    $poids = round($resultat['PoidsMoyen'] ?? 0, 2);
    $age = round($resultat['AgeMoyen'] ?? 0, 2);

    $data_chart = [$taille, $poids, $age];


    if ($taille === 0.0 && $poids === 0.0 && $age === 0.0) {
        $data_chart = [1, 1, 1];

        $labels_chart = ['Taille (0)', 'Poids (0)', 'Âge (0)'];
    }


    $json_labels = json_encode($labels_chart);
    $json_data = json_encode($data_chart);

} catch (PDOException $e) {

    $json_labels = json_encode(['Erreur de BD']);
    $json_data = json_encode([1, 1, 1]); 
}
?>

<div class="container text-center mt-5 my-5" style="background-image: url('../images/hierarchie.png'); background-size: cover; background-repeat: no-repeat; background-position: center; padding: 50px; border-radius: 10px;">
      <div  class="d-flex flex-column justify-content-center align-items-center text-center mb-4">
      <h3 class="text-white">Accès à l'orphelinat</h3>
          <div class="d-flex align-items-center justify-content-evenly mt-4 " >
            <?php
            if (isset($_SESSION['user'])) {
              if ($_SESSION['user']['role'] === 'admin') {
                  echo '<a href="../affichage/AffichageUtilisateur.php" class="btn btn-secondary ms-2">Accéder à la liste des utilisateurs</a>';
              }
              echo '<a href="../affichage/AffichageEnfant.php" class="btn btn-secondary ms-2">Accéder à la liste des orphelins</a>';

              echo '<a href="../affichage/AffichageFournisseur.php" class="btn btn-secondary ms-2">Accéder à la liste des fournisseurs</a>';
            } else {
              echo '<a href="connexion.php" class="btn btn-secondary ms-2">Vous n\'avez pas accès aux listes</a>';
            }
            ?>
          </div>
      </div>
</div>

<?php 
if (isset($_SESSION['isLog'])) {
    echo '<div class="container mb-5" style="background-color: white; padding: 20px; border-radius: 10px; max-width: 500px;">
            <h4 class="text-center mb-4">⚖️ Statistiques Moyennes des Enfants (Poids, Taille, Âge)</h4>
            <canvas id="myDonutChart"></canvas>
          </div>';
}
?>

<img src="../images/hierarchie.png" alt="Accès Orphelinat" class="img-fluid d-block mx-auto mb-5" style="max-width: 80%; border-radius: 10px;">
   <?php include '../headerFooter/footer.php'; ?>

<script>

    const donut_labels_js = <?php echo $json_labels; ?>;
    const donut_data_js = <?php echo $json_data; ?>;
    
    const donutCtx = document.getElementById('myDonutChart');

    if (donutCtx) {
        new Chart(donutCtx, {
            type: 'polarArea', 
            data: {
                labels: donut_labels_js, 
                datasets: [{
                    label: 'Valeur moyenne', 
                    data: donut_data_js, 
                    backgroundColor: [
                        'rgba(32, 70, 27, 0.9)',    // Vert foncé
                        'rgba(168, 203, 107, 0.9)', // Vert clair
                        'rgba(255, 193, 7, 0.9)'    // Jaune
                    ],
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Comparaison des Indicateurs Moyens'
                    }
                }
            }
        });
    }
</script>

</body>
</html>