<?php
session_start();

// Vérification des identifiants de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin123') {
        // Les identifiants sont corrects, connecter l'administrateur
        $_SESSION['admin'] = true;
        header("Location: index.php"); // Rediriger vers la page principale
        exit;
    } else {
        // Identifiants incorrects, afficher un message d'erreur
        $erreur = "Identifiants incorrects";
    }
}

// Retourner les données à utiliser dans le contrôleur
return [
    'erreur' => isset($erreur) ? $erreur : null
];
?>
