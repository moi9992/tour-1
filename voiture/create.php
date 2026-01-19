<?php
require_once 'config.php';

$currentPage = 'create';
$pageTitle = 'Ajouter une voiture';
$pdo = getDbConnection();

$errors = [];
$data = [
    'marque' => '',
    'modele' => '',
    'annee' => '',
    'couleur' => '',
    'immatriculation' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $_SESSION['message'] = "Jeton CSRF invalide.";
        $_SESSION['message_type'] = 'error';
        header('Location: create.php');
        exit;
    }
    
    $data = [
        'marque' => trim($_POST['marque'] ?? ''),
        'modele' => trim($_POST['modele'] ?? ''),
        'annee' => trim($_POST['annee'] ?? ''),
        'couleur' => trim($_POST['couleur'] ?? ''),
        'immatriculation' => strtoupper(trim($_POST['immatriculation'] ?? ''))
    ];
    
    if (validateVoiture($data, $errors)) {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO voitures (marque, modele, annee, couleur, immatriculation) 
                 VALUES (:marque, :modele, :annee, :couleur, :immatriculation)"
            );
            $stmt->execute($data);
            $_SESSION['message'] = "Voiture ajoutée avec succès !";
            $_SESSION['message_type'] = 'success';
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $errors['immatriculation'] = "Cette immatriculation existe déjà.";
            } else {
                $errors['general'] = "Erreur lors de l'ajout : " . $e->getMessage();
            }
        }
    }
}

$csrfToken = generateCsrfToken();

include 'includes/header.php';
?>

<div class="card">
    <div class="card-header">
        <h2>Ajouter une voiture</h2>
    </div>
    
    <form method="POST" action="create.php">
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
            <button type="submit" class="btn btn-primary">Ajouter la voiture</button>
            <a href="index.php" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>