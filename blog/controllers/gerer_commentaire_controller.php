<?php
// Inclure le modèle
$data = include 'gerer_commentaire_model.php';

// Extraire les données du modèle
extract($data);

// Inclure la vue
include 'gerer_commentaire_view.php';
?>
