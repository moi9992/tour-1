<?php
require '../session/db.php'; 

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../session/connexion.php');
    exit;
}

$userId = $_SESSION['user']['id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("DELETE FROM Utilisateurs WHERE id = ?");
        $stmt->execute([$userId]);

        session_destroy();

        header('Location: ../mainPages/accueil.php');
        exit;
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger text-center'>Erreur : " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer mon compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Supprimer mon compte</h2>

    <?= $message ?>

    <div class="alert alert-warning text-center">
        Êtes-vous sûr de vouloir supprimer votre compte ? </strong>.
    </div>

    <form method="POST" class="text-center">
        <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
        <a href="../session/compte.php?Id=<?= $userId ?>" class="btn btn-secondary ms-2">Annuler</a>
    </form>
</div>
</body>
</html>