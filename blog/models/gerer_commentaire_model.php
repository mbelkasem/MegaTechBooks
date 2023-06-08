<?php
// Connexion à la base de données
$connexion = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

// Récupérer l'identifiant du billet pour lequel afficher les commentaires
$billetId = $_GET['id'];

// Récupérer les informations du billet depuis la base de données
$requeteBillet = $connexion->prepare('SELECT * FROM billets WHERE id = :id');
$requeteBillet->bindParam(':id', $billetId);
$requeteBillet->execute();
$billet = $requeteBillet->fetch(PDO::FETCH_ASSOC);

// Vérifier si le billet existe
if (!$billet) {
    // Rediriger vers une page d'erreur ou une page de gestion des billets
    header("Location: erreur.php");
    exit;
}

// Récupérer les commentaires associés au billet depuis la base de données
$requeteCommentaires = $connexion->prepare('SELECT * FROM commentaires WHERE billet_id = :id');
$requeteCommentaires->bindParam(':id', $billetId);
$requeteCommentaires->execute();
$commentaires = $requeteCommentaires->fetchAll(PDO::FETCH_ASSOC);

// Retourner les données à utiliser dans le contrôleur
return [
    'billet' => $billet,
    'commentaires' => $commentaires
];
?>
