<?php
session_start();

// Vérifier si l'administrateur est connecté
if (isset($_SESSION['admin'])) {
    // L'administrateur est déjà connecté, rediriger vers la page principale
    header("Location: index.php");
    exit;
}

// Vérification des identifiants de connexion
if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin123') {
    // Les identifiants sont corrects, connecter l'administrateur
    $_SESSION['admin'] = true;
    header("Location: index.php"); // Rediriger vers la page principale
    exit;
} else {
    // Identifiants incorrects, rediriger vers la page de connexion avec un message d'erreur
    header("Location: connexion.php?erreur=1");
    exit;
}
?>
