<?php
require_once 'config.php';

$pdo = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    $_SESSION['message'] = "Jeton CSRF invalide.";
    $_SESSION['message_type'] = 'error';
    header('Location: index.php');
    exit;
}

$id = intval($_POST['id'] ?? 0);

try {
    $stmt = $pdo->prepare("DELETE FROM voitures WHERE id = :id");
    $stmt->execute(['id' => $id]);
    
    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = "Voiture supprimée avec succès !";
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = "Voiture introuvable.";
        $_SESSION['message_type'] = 'error';
    }
} catch (PDOException $e) {
    $_SESSION['message'] = "Erreur lors de la suppression : " . $e->getMessage();
    $_SESSION['message_type'] = 'error';
}

header('Location: index.php');
exit;
?>