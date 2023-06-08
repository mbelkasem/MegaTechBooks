<?php
require __DIR__.'/vendor/autoload.php';

// Connexion à la base de données
$connexion = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

// Récupérer les données du formulaire
$titre = $_POST['titre'];
$texte = $_POST['texte'];

// Vérifier si les champs sont remplis
if (!empty($titre) && !empty($texte)) {
    // Insérer le nouveau billet dans la base de données
    $requeteInsertion = $connexion->prepare('INSERT INTO billets (titre, texte) VALUES (:titre, :texte)');
    $requeteInsertion->bindParam(':titre', $titre);
    $requeteInsertion->bindParam(':texte', $texte);
    $requeteInsertion->execute();
}

// Rediriger vers la page d'accueil
header("Location: index.php");
exit;
?>
