<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orphelinat au petit Cuit-cuit</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-TLHRYtxFDLVLkxNT2E6HyKffUg6fS5NBfGG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="../styles/restau.css">
        <link rel="stylesheet" href="../styles/style.css">
</head>
<body>

<!-- Barre de Navigation (Header) -->
<?php include '../headerFooter/header.php'; ?>

    <div class="head-section">
        
        <div class="head-overlay">
            <h1 class="display-3 fw-bold text-center">restaurant<br>du trop cuit</h1>
            <div class="star-rating"> ⛧⛧⛧⛧⛧</div>      
        </div>
    </div>

    <main class="main-content">
        <div class="container">
            <p class="text-center lead my-5 mx-auto" style="max-width: 700px;">
                Dans ce restaurant retrouvez des plats gastro préparés avec grand soin par notre chef cuisto. Des produits et viandes locale et bio élevés dans le plus grand soin et la discipline pour une viande équilibrée.
            </p>

            <h2 class="text-center mb-4">plats phares</h2>
            <div class="row text-center mb-5 justify-content-center">
                
                <div class="col-12 col-md-4 col-lg-3 plat-card">
                    <img src="../images/estomac.png" class="img-fluid" alt="Escargot garni">
                    <p class="mt-2 mb-0 fw-bold">Estomac garni</p>
                    <p class="small text-muted fst-italic">viande locale et bio</p>
                    <p class="text-brown">$10.99</p>
                </div>

                <div class="col-12 col-md-4 col-lg-3 plat-card">
                    <img src="../images/ragoutDouteux.png" class="img" alt="Ragout douteux">
                    <p class="mt-2 mb-0 fw-bold">Ragout douteux</p>
                    <p class="small text-muted fst-italic">inspiré des plus grands rêves de nos panssionnaires</p>
                    <p class="text-brown">$7.99</p>
                </div>

                <div class="col-12 col-md-4 col-lg-5 plat-card">
                    <img src="../images/truc.png" class="img" alt="Oeufs de rongeur bouillis à la bave de soja">
                    <p class="mt-2 mb-0 fw-bold">Œufs de rongeur bouillis à la bave de soja</p>
                    <p class="small text-muted fst-italic">Fromage non identifié</p>
                    <p class="text-brown">$12.99</p>
                </div>
            </div>
            
            <hr>
            
            <h2 class="text-center my-4">autres produits</h2>
            <div class="row mb-5">
                
                <div class="col-md-6 other-product d-flex align-items-center">
                    <div>
                        <p class="fw-bold mb-0">Hákarl (Islande)</p>
                        <p class="small text-muted mb-0">Ce met national islandais sert comme un mélange de fromage cuistré et de crotte chaudoyante. Parfait si le fromage frais est votre ingrédient !</p>
                    </div>
                </div>
                
                <div class="col-md-6 other-product d-flex align-items-center">
                    <div>
                        <p class="fw-bold mb-0">Balut (Philippines)</p>
                        <p class="small text-muted mb-0">Ce met philippin sert comme un embryon à l'intérieur, à se choisir entre un snack et un film (homme) toujours accompagné de sa mère.</p>
                    </div>
                </div>

                <div class="col-md-6 other-product d-flex align-items-center">
                    <div>
                        <p class="fw-bold mb-0">Surströmming (Suède)</p>
                        <p class="small text-muted mb-0">Ce met national suédois sert comme l'une larve en scène de crime olfactive. Attention aux nez sensibles, c'est un piège !</p>
                    </div>
                </div>
                
                <div class="col-md-6 other-product d-flex align-items-center">
                    <div>
                        <p class="fw-bold mb-0">Casu Marzu (Sardaigna, Italie)</p>
                        <p class="small text-muted mb-0">Ce fromage sarde est le plus infectieux. Le goût est amer, il est toujours accompagné de rongeur encore à ses regards de travail.</p>
                    </div>
                </div>
            </div>

            <div class="row interieur-section">
                <div class="col-12">
                    <img src="../images/interior.png" class="img-fluid" alt="Intérieur du restaurant">
                </div>
            </div>
            
            <p class="text-center lead mt-4 mb-5 mx-auto" style="max-width: 500px;">
                Dans cet établissement vous vous sentirez comme à la maison
            </p>

        </div>
        </main>
<?php include '../headerFooter/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>