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

<div class="container mt-5">
  <h1 class="text-center">Bienvenue à l'orphelinat “Au petit Cuit-cuit”</h1>
  <p class="lead mt-5"> Perdu au bout d'une route que personne n'emprunte, l'orphelinat « Au Petit Cuit-cuit » recueille les enfants que le monde préfère oublier. Ici, le silence est épais, les souvenirs ont une odeur… et les pensionnaires disparaissent parfois entre deux services. On y apprend la discipline, la discrétion, et quelques recettes familiales. Certains viennent y chercher une seconde chance. D'autres, un bon repas. Quoi qu'il en soit, on vous servira chaud.<br /><br />
  <span class="fw-bold">« Ici, on adopte… ou on cuisine. »</span></p>
  <p class="text-center fs-2 fw-bold" style="color:#BFD641;"> Entre ombres et saveurs, à vous de décider :</p>
</div>

<div class="container my-5">
  <div class="row">
    <div class="col-md-6 d-flex flex-column align-items-center">
      <h4 class="mb-4 text-center">L'orphelinat</h4>
      <img src="../images/Orphelinat.webp" alt="Orphelinat" class="img-fluid rounded mb-3" style="height: 800px; object-fit: cover; width: 100%;"/>
      <p class="text-center"> Discipline, hygiène et savoir-faire. Nourris, logés, préparés… tout est inclus.</p>
      <a href="orphelinat.php" class="btn btn-success px-4 fs-5 fw-bold" style="background-color:#BFD641; border-color:#BFD641;">À visiter</a>
    </div>
    <div class="col-md-6 d-flex flex-column align-items-center">
      <h4 class="mb-4 text-center">Le restaurant</h4>
      <img src="../images/Restaurant.png" alt="Restaurant" class="img-fluid rounded mb-3" style="height: 800px; object-fit: cover; width: 100%;"/>
      <p class="text-center"> Cuisine locale, discrète et inoubliable. Dégustez des plats uniques.</p>
      <a href="restaurant.php" class="btn btn-success px-4 fs-5 fw-bold" style="background-color:#BFD641; border-color:#BFD641;">À déguster</a>
    </div>
  </div>
</div>

<div class="container my-5 pb-3">
  <div class="d-flex justify-content-between text-center">
    <div class="col-md-3 fs-3">
      <div class="bg-black py-5 p-4 rounded-3 text-center border-start border-end border-3" style="color: #BFD641; box-shadow: 15px 15px 30px 0px rgb(217, 255, 0);">
        <p class="fw-bold">52</p>
        <i class="bi bi-droplet-fill fs-2 mb-3 d-block"></i>
        <p>Enfants accueillis</p>
      </div>
    </div>
    <div class="col-md-3 fs-3">
      <div class="bg-black py-5 p-4 rounded-3 text-center border-start border-end border-3" style="border-color: #BFD641; color: #BFD641; box-shadow: 15px 15px 30px 0px rgb(217, 255, 0);">
        <p class="fw-bold">2</p>
        <i class="bi bi-calendar-fill fs-2 mb-3 d-block"></i>
        <p>Années d'existence</p>
      </div>
    </div>
    <div class="col-md-3 fs-3">
      <div class="bg-black py-5 p-4 rounded-3 text-center border-start border-end border-3" style="border-color: #BFD641; color: #BFD641; box-shadow: 15px 15px 30px 0px rgb(217, 255, 0);">
        <p class="fw-bold">340</p>
        <i class="bi bi-egg-fried fs-2 mb-3 d-block"></i>
        <p>Plats servis</p>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php include '../headerFooter/footer.php'; ?>
</body>
</html>

