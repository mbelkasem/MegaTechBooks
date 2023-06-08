<?php
require __DIR__.'/vendor/autoload.php';

// Connexion à la base de données
$connexion = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

// Récupérer le terme de recherche
$recherche = $_GET['q'];

// Requête de recherche des billets
$requeteRecherche = $connexion->prepare('SELECT * FROM billets WHERE titre LIKE :recherche');
$requeteRecherche->bindValue(':recherche', '%' . $recherche . '%');
$requeteRecherche->execute();
$billets = $requeteRecherche->fetchAll(PDO::FETCH_ASSOC);

// Inclure le fichier du template des résultats de recherche
include 'templates/resultats_recherche.html';
?>
