<?php
// Connexion à la base de données "premierCrud" avec l'utilisateur "root" et sans mot de passe.
// PDO (PHP Data Objects) est utilisé ici car il est plus moderne et sécurisé que mysqli.
$pdo = new PDO("mysql:host=localhost;dbname=premierCrud", "root", "");

// On configure PDO pour qu'il lance une exception (erreur fatale) si une erreur SQL se produit.
// Cela permet de repérer facilement les erreurs et de les gérer avec try/catch dans les autres fichiers.
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>