<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'gestion_voitures');
define('DB_USER', 'root');
define('DB_PASS', '');

function getDbConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion : " . htmlspecialchars($e->getMessage()));
    }
}

function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function escape($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function validateVoiture($data, &$errors) {
    $valid = true;
    
    if (empty($data['marque'])) {
        $errors['marque'] = "La marque est obligatoire.";
        $valid = false;
    } elseif (strlen($data['marque']) < 2 || strlen($data['marque']) > 50) {
        $errors['marque'] = "La marque doit contenir entre 2 et 50 caractères.";
        $valid = false;
    }
    
    if (empty($data['modele'])) {
        $errors['modele'] = "Le modèle est obligatoire.";
        $valid = false;
    } elseif (strlen($data['modele']) < 1 || strlen($data['modele']) > 50) {
        $errors['modele'] = "Le modèle doit contenir entre 1 et 50 caractères.";
        $valid = false;
    }
    
    if (empty($data['annee'])) {
        $errors['annee'] = "L'année est obligatoire.";
        $valid = false;
    } elseif (!is_numeric($data['annee']) || $data['annee'] < 1900 || $data['annee'] > date('Y')) {
        $errors['annee'] = "L'année doit être entre 1900 et " . date('Y') . ".";
        $valid = false;
    }
    
    if (!empty($data['couleur']) && strlen($data['couleur']) > 30) {
        $errors['couleur'] = "La couleur ne peut pas dépasser 30 caractères.";
        $valid = false;
    }
    
    if (empty($data['immatriculation'])) {
        $errors['immatriculation'] = "L'immatriculation est obligatoire.";
        $valid = false;
    } elseif (!preg_match('/^[A-Z]{2}-?\d{3}-?[A-Z]{2}$/i', $data['immatriculation'])) {
        $errors['immatriculation'] = "Format invalide (attendu : AA-123-BB ou AA123BB).";
        $valid = false;
    }
    
    return $valid;
}

session_start();
?>