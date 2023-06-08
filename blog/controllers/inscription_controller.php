<?php
// Inclure le modèle
include 'inscription_model.php';

// Vérification du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données saisies par l'utilisateur
    $nomUtilisateur = $_POST['nom_utilisateur'];
    $motDePasse = $_POST['mot_de_passe'];
    $email = $_POST['email'];

    // Validation des données saisies (vous pouvez ajouter des validations supplémentaires selon vos besoins)

    if (inscription($nomUtilisateur, $motDePasse, $email)) {
        // Redirection vers une page de succès ou vers la page de connexion
        header("Location: inscription_succes.php");
        exit;
    } else {
        // Gestion des erreurs d'insertion dans la base de données
        echo "Une erreur est survenue lors de l'inscription.";
    }
}
?>
