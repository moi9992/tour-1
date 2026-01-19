<?php
require_once 'config.php';

$currentPage = 'liste';
$pageTitle = 'Liste des voitures';
$pdo = getDbConnection();

$message = $_SESSION['message'] ?? null;
$messageType = $_SESSION['message_type'] ?? 'info';
unset($_SESSION['message'], $_SESSION['message_type']);

$stmt = $pdo->query("SELECT * FROM voitures ORDER BY created_at DESC");
$voitures = $stmt->fetchAll();

$csrfToken = generateCsrfToken();

include 'includes/header.php';
?>

<div class="card">
    <div class="card-header">
        <h2>📋 Liste des voitures</h2>
    </div>
    
    <?php if ($message): ?>
        <div class="message <?= escape($messageType) ?>">
            <?= escape($message) ?>
        </div>
    <?php endif; ?>
    
    <?php if (empty($voitures)): ?>
        <div class="empty-state">
            <p>Aucune voiture enregistrée</p>
            <p>Commencez par <a href="create.php">ajouter votre première voiture</a>.</p>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Année</th>
                    <th>Couleur</th>
                    <th>Immatriculation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($voitures as $voiture): ?>
                    <tr>
                        <td><?= escape($voiture['id']) ?></td>
                        <td><?= escape($voiture['marque']) ?></td>
                        <td><?= escape($voiture['modele']) ?></td>
                        <td><?= escape($voiture['annee']) ?></td>
                        <td><?= escape($voiture['couleur'] ?: '—') ?></td>
                        <td><strong><?= escape($voiture['immatriculation']) ?></strong></td>
                        <td>
                            <div class="actions">
                                <a href="edit.php?id=<?= escape($voiture['id']) ?>" class="btn btn-edit">✏️ Modifier</a>
                                <form method="POST" action="delete.php" style="display: inline;" 
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette voiture ?');">
                                    <input type="hidden" name="csrf_token" value="<?= escape($csrfToken) ?>">
                                    <input type="hidden" name="id" value="<?= escape($voiture['id']) ?>">
                                    <button type="submit" class="btn btn-delete">🗑️ Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>