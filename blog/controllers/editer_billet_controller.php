<?php
require_once 'models/BilletModel.php';

// Vérification du paramètre d'identifiant du billet
if (isset($_GET['id'])) {
    $billetId = $_GET['id'];

    // Récupération du billet depuis le modèle
    $billet = BilletModel::getBillet($billetId);

    // Vérification si le billet existe
    if ($billet) {
        // Vérification de la soumission du formulaire de modification
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nouveauTitre = $_POST['titre'];
            $nouveauTexte = $_POST['texte'];

            // Mise à jour du billet dans le modèle
            BilletModel::updateBillet($billetId, $nouveauTitre, $nouveauTexte);

            // Redirection vers la page de détails du billet
            header("Location: details_billet.php?id=$billetId");
            exit;
        }

        // Inclusion de la vue pour afficher le formulaire de modification du billet
        require 'views/editer_billet_view.php';
    } else {
        // Gestion de l'erreur si le billet n'existe pas
        echo "Le billet demandé n'existe pas.";
    }
} else {
    // Gestion de l'erreur si aucun identifiant de billet n'est spécifié
    echo "Aucun identifiant de billet spécifié.";
}
?>
