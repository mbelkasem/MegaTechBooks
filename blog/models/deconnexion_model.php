<?php
session_start();

// Déconnexion de l'administrateur
session_unset();
session_destroy();

// Rediriger vers la page de connexion
header("Location: connexion.php");
exit;
?>
