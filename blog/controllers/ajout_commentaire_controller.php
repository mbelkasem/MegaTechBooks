<?php
session_start();

// Inclure le modèle
include 'commentaires_model.php';

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
    // Rediriger vers une page d'erreur ou une page de connexion
    header("Location: erreur.php");
    exit;
}

// Récupérer l'identifiant du billet pour lequel ajouter un commentaire
$billetId = $_GET['id'];

// Récupérer les informations du billet
$billet = getBillet($billetId);

// Vérifier si le billet existe
if (!$billet) {
    // Rediriger vers une page d'erreur ou une page de gestion des billets
    header("Location: erreur.php");
    exit;
}

// Traitement du formulaire d'ajout de commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentaire = $_POST['commentaire'];

    // Vérifier si le champ est rempli
    if (!empty($commentaire)) {
        // Ajouter le commentaire
        ajouterCommentaire($billetId, $commentaire);

        // Rediriger vers la page de gestion des commentaires
        header("Location: gerer_commentaires.php?id=".$billetId);
        exit;
    }
}

// Inclure la vue
include 'ajout_commentaire_view.php';
?>
