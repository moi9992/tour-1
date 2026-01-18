<?php
session_start();
session_destroy();
header('Location: ../mainPages/accueil.php');
exit;
?>