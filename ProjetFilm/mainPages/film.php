<?php
require_once __DIR__ . '/../api/tmdb.php';
include '../headerFooter/header.php';

if (empty($_GET['id'])) {
    echo "<div class='container my-5'><p class='text-danger'>Film non trouvé.</p></div>";
    include '../headerFooter/footer.php';
    exit;
}

$filmId = intval($_GET['id']);

// 🔹 Récupération du film
$movie = getMovie($filmId);

if (!$movie) {
    echo "<div class='container my-5'><p class='text-danger'>Film non disponible (Romance filtrée pour mineurs ou non connecté).</p></div>";
    include '../headerFooter/footer.php';
    exit;
}

// 🔹 Films similaires
$similarMovies = getSimilarMovies($filmId, 8);

// 🔹 Casting principal (top 5)
$credits = tmdbRequest("/movie/$filmId/credits")['cast'] ?? [];
$topCast = array_slice($credits, 0, 5);
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-4">
            <?php if (!empty($movie['poster_path'])): ?>
                <img src="https://image.tmdb.org/t/p/w500<?= $movie['poster_path'] ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($movie['title']) ?>">
            <?php else: ?>
                <div class="bg-secondary d-flex align-items-center justify-content-center" style="height:500px;">
                    <span class="text-light">Pas d’image</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-8">
            <h1><?= htmlspecialchars($movie['title']) ?></h1>
            <p class="text-muted">Sortie : <?= htmlspecialchars($movie['release_date']) ?></p>
            <p class="text-warning">⭐ <?= $movie['vote_average'] ?>/10</p>
            
            <!-- 🔹 Durée -->
            <p class="text-dark">Durée : 
                <?php 
                if (!empty($movie['runtime'])) {
                    $hours = floor($movie['runtime'] / 60);
                    $minutes = $movie['runtime'] % 60;
                    echo $hours . "h " . $minutes . "min";
                } else {
                    echo "N/A";
                }
                ?>
            </p>

            <h5>Description :</h5>
            <p><?= htmlspecialchars($movie['overview']) ?></p>

            <?php if (!empty($movie['genres'])): ?>
                <h6>Genres :</h6>
                <ul>
                    <?php foreach ($movie['genres'] as $genre): ?>
                        <li><?= htmlspecialchars($genre['name']) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <!-- 🔹 Casting principal -->
            <?php if (!empty($topCast)): ?>
                <h6>Casting principal :</h6>
                <ul>
                    <?php foreach ($topCast as $actor): ?>
                        <li><?= htmlspecialchars($actor['name']) ?> dans le rôle de <?= htmlspecialchars($actor['character']) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if (!empty($similarMovies)): ?>
<div class="container my-5">
    <h3 class="mb-3">Films similaires</h3>
    <div class="row">
        <?php foreach ($similarMovies as $sim): ?>
            <div class="col-md-3 mb-4">
                <a href="film.php?id=<?= $sim['id'] ?>" class="text-decoration-none text-light">
                    <div class="card bg-dark text-light h-100">
                        <?php if (!empty($sim['poster_path'])): ?>
                            <img src="https://image.tmdb.org/t/p/w300<?= $sim['poster_path'] ?>" class="card-img-top" alt="<?= htmlspecialchars($sim['title']) ?>">
                        <?php else: ?>
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height:375px;">
                                <span class="text-muted">Pas d’image</span>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h6 class="card-title"><?= htmlspecialchars($sim['title']) ?></h6>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php include '../headerFooter/footer.php'; ?>
