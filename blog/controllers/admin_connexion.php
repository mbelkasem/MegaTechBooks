<?php
session_start();

// Vérification des identifiants de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin123') {
        // Les identifiants sont corrects, connecter l'administrateur
        $_SESSION['admin'] = true;
        header("Location: gestion_billets.php"); // Rediriger vers la page de gestion des billets
        exit;
    } else {
        // Identifiants incorrects, afficher un message d'erreur
        $erreur = "Identifiants incorrects";
        include 'admin.php'; // Inclure à nouveau la vue avec le message d'erreur
    }
}
?>
