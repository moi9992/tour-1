<!-- Barre de Navigation (Header) -->
<nav class="navbar navbar-expand-lg header-footer-dark px-3">
    <div class="container-fluid d-flex justify-content-between align-items-center px-4">
          <a class="navbar-brand text-dark" href="../mainPages/accueil.php">Orphelinat au petit Cuit-cuit</a>

        <div class="d-flex align-items-center">
            <!-- Liens de navigation -->
            <a class="nav-link text-dark me-3" href="../mainPages/accueil.php">Accueil</a>
            <a class="nav-link text-dark me-3" href="../mainPages/orphelinat.php">Orphelinat</a>
            <a class="nav-link text-dark me-3" href="../mainPages/restaurant.php">Restaurant</a>
            <!-- Bouton de connexion -->
            <?php
            
             session_start();
            //autre possibilité
            // if (isset($_SESSION['user'])) {
            // // L'utilisateur est connecté, afficher le lien vers son compte
            //   echo '<a href="compte.php?Id=' . $_SESSION['user']['id'] . '" class="btn btn-secondary ms-2">Mon compte</a>';
            // } else {
            // // L'utilisateur n'est pas connecté, afficher le bouton de connexion
            //   echo '<a href="connexion.php" class="btn btn-secondary ms-2">Se connecter</a>';
            // }
             ?>
             <?php
             if (empty($_SESSION['isLog'])):
              ?>
            <a href="../session/connexion.php" class="btn btn-secondary ms-2">Se connecter</a>
            <?php endif;
            if (!empty($_SESSION['isLog'])):
             ?>
              <a href="../session/compte.php?Id=<?php echo $_SESSION['user']['id']; ?>" class="btn btn-secondary ms-2">Mon compte</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
