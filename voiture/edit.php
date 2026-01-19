<?php
require_once 'config.php';

$currentPage = 'edit';
$pageTitle = 'Modifier une voiture';
$pdo = getDbConnection();

$id = intval($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM voitures WHERE id = :id");
$stmt->execute(['id' => $id]);
$voiture = $stmt->fetch();

if (!$voiture) {
    $_SESSION['message'] = "Voiture introuvable.";
    $_SESSION['message_type'] = 'error';
    header('Location: index.php');
    exit;
}

$errors = [];
$data = $voiture;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $_SESSION['message'] = "Jeton CSRF invalide.";
        $_SESSION['message_type'] = 'error';
        header('Location: edit.php?id=' . $id);
        exit;
    }
    
    $data = [
        'id' => $id,
        'marque' => trim($_POST['marque'] ?? ''),
        'modele' => trim($_POST['modele'] ?? ''),
        'annee' => trim($_POST['annee'] ?? ''),
        'couleur' => trim($_POST['couleur'] ?? ''),
        'immatriculation' => strtoupper(trim($_POST['immatriculation'] ?? ''))
    ];
    
    if (validateVoiture($data, $errors)) {
        try {
            $stmt = $pdo->prepare(
                "UPDATE voitures 
                 SET marque = :marque, modele = :modele, annee = :annee, 
                     couleur = :couleur, immatriculation = :immatriculation 
                 WHERE id = :id"
            );
            $stmt->execute($data);
            $_SESSION['message'] = "Voiture modifiée avec succès !";
            $_SESSION['message_type'] = 'success';
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $errors['immatriculation'] = "Cette immatriculation existe déjà.";
            } else {
                $errors['general'] = "Erreur lors de la modification : " . $e->getMessage();
            }
        }
    }
}

$csrfToken = generateCsrfToken();

include 'includes/header.php';
?>

<div class="card">
    <div class="card-header">
        <h2>✏️ Modifier la voiture #<?= escape($id) ?></h2>
    </div>
    
    <form method="POST" action="edit.php?id=<?= escape($id) ?>">
        <input type="hidden" name="csrf_token" value="<?= escape($csrfToken) ?>">
        
        <div class="form-grid">
            <div class="form-group">
                <label for="marque">Marque *</label>
                <input type="text" id="marque" name="marque" 
                       value="<?= escape($data['marque']) ?>" 
                       placeholder="ex: Renault" required>
                <?php if (isset($errors['marque'])): ?>
                    <span class="error-text"><?= escape($errors['marque']) ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="modele">Modèle *</label>
                <input type="text" id="modele" name="modele" 
                       value="<?= escape($data['modele']) ?>" 
                       placeholder="ex: Clio" required>
                <?php if (isset($errors['modele'])): ?>
                    <span class="error-text"><?= escape($errors['modele']) ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="annee">Année *</label>
                <input type="number" id="annee" name="annee" 
                       value="<?= escape($data['annee']) ?>" 
                       placeholder="ex: 2020" min="1900" max="<?= date('Y') ?>" required>
                <?php if (isset($errors['annee'])): ?>
                    <span class="error-text"><?= escape($errors['annee']) ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="couleur">Couleur</label>
                <input type="text" id="couleur" name="couleur" 
                       value="<?= escape($data['couleur']) ?>" 
                       placeholder="ex: Bleu">
                <?php if (isset($errors['couleur'])): ?>
                    <span class="error-text"><?= escape($errors['couleur']) ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="immatriculation">Immatriculation *</label>
                <input type="text" id="immatriculation" name="immatriculation" 
                       value="<?= escape($data['immatriculation']) ?>" 
                       placeholder="ex: AA-123-BB" required>
                <?php if (isset($errors['immatriculation'])): ?>
                    <span class="error-text"><?= escape($errors['immatriculation']) ?></span>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if (isset($errors['general'])): ?>
            <div class="error-text" style="margin-bottom: 15px;"><?= escape($errors['general']) ?></div>
        <?php endif; ?>
        
        <div>
            <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
            <a href="index.php" class="btn btn-secondary">❌ Annuler</a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>