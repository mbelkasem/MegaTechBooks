<?php
require __DIR__.'/vendor/autoload.php';

function inscription($nomUtilisateur, $motDePasse, $email) {
    // Connexion à la base de données
    $connexion = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

    // Insertion des données d'inscription dans la table des utilisateurs
    $requete = $connexion->prepare('INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, email) VALUES (:nom_utilisateur, :mot_de_passe, :email)');
    $requete->bindParam(':nom_utilisateur', $nomUtilisateur);
    $requete->bindParam(':mot_de_passe', $motDePasse);
    $requete->bindParam(':email', $email);

    return $requete->execute();
}
?>
