<?php
session_start();

// Vérifier si l'administrateur est connecté
if (!isset($_SESSION['admin'])) {
    // Rediriger vers la page d'authentification avec un message d'erreur
    header("Location: traitement_connexion.php?erreur=1");
    exit;
}

// Connexion à la base de données
$connexion = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

// Récupérer les billets du blog depuis la base de données
$requete = $connexion->query('SELECT * FROM billets ORDER BY id DESC');
$billets = $requete->fetchAll(PDO::FETCH_ASSOC);

// Inclure le template index.html
include 'templates/index.html';

// Traitement du formulaire d'ajout de billet
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'utilisateur est bien l'administrateur
    if ($_SESSION['admin'] === 'admin_id') {
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
    }
}
?>
