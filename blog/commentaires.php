<?php
require __DIR__.'/vendor/autoload.php';

// Connexion à la base de données
$connexion = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

// Récupérer l'identifiant du billet à afficher les commentaires
$billetId = $_GET['billet_id'];

// Récupérer les informations du billet
$requeteBillet = $connexion->prepare('SELECT * FROM billets WHERE id = :billet_id');
$requeteBillet->bindParam(':billet_id', $billetId);
$requeteBillet->execute();
$billet = $requeteBillet->fetch(PDO::FETCH_ASSOC);

// Récupérer les commentaires associés au billet
$requeteCommentaires = $connexion->prepare('SELECT * FROM commentaires WHERE billet_id = :billet_id');
$requeteCommentaires->bindParam(':billet_id', $billetId);
$requeteCommentaires->execute();
$commentaires = $requeteCommentaires->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire d'ajout de commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $texte = $_POST['texte'];

    // Vérifier si le champ est rempli
    if (!empty($texte)) {
        // Insérer le nouveau commentaire dans la base de données
        $requeteInsertion = $connexion->prepare('INSERT INTO commentaires (billet_id, texte) VALUES (:billet_id, :texte)');
        $requeteInsertion->bindParam(':billet_id', $billetId);
        $requeteInsertion->bindParam(':texte', $texte);
        $requeteInsertion->execute();
    }
}

// Inclure le fichier du template des commentaires
include 'templates/commentaires.html';
?>
