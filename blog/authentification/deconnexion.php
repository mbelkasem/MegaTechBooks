<?php
session_start();

// Déconnexion de l'administrateur
session_unset();
session_destroy();

header("Location: connexion.php"); // Rediriger vers la page de connexion
exit;
?>
