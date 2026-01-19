<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Gestion de Voitures' ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <h1>🚗 Gestion de Voitures</h1>
            <ul class="nav-menu">
                <li><a href="index.php" class="<?= ($currentPage ?? '') === 'liste' ? 'active' : '' ?>">📋 Liste</a></li>
                <li><a href="create.php" class="<?= ($currentPage ?? '') === 'create' ? 'active' : '' ?>">➕ Ajouter</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">