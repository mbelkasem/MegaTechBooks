<?php
require __DIR__.'/vendor/autoload.php';

// Vérification du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données saisies par l'utilisateur
    $nomUtilisateur = $_POST['nom_utilisateur'];
    $motDePasse = $_POST['mot_de_passe'];
    $email = $_POST['email'];

    // Validation des données saisies (vous pouvez ajouter des validations supplémentaires selon vos besoins)

    // Connexion à la base de données
    $connexion = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

    // Insertion des données d'inscription dans la table des utilisateurs
    $requete = $connexion->prepare('INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, email) VALUES (:nom_utilisateur, :mot_de_passe, :email)');
    $requete->bindParam(':nom_utilisateur', $nomUtilisateur);
    $requete->bindParam(':mot_de_passe', $motDePasse);
    $requete->bindParam(':email', $email);

    if ($requete->execute()) {
        // Redirection vers une page de succès ou vers la page de connexion
        header("Location: inscription_succes.php");
        exit;
    } else {
        // Gestion des erreurs d'insertion dans la base de données
        echo "Une erreur est survenue lors de l'inscription.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>

    <form method="POST" action="inscription.php">
        <label for="nom_utilisateur">Nom d'utilisateur :</label>
        <input type="text" id="nom_utilisateur" name="nom_utilisateur" required><br><br>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required><br><br>

        <label for="email">Adresse e-mail :</label>
        <input type="email" id="email" name="email" required><br><br>

        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>
