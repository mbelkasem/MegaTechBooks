<?php
// Inclure le modèle
$data = include 'connexion_model.php';

// Extraire les données du modèle
extract($data);

// Inclure la vue
include 'connexion_view.php';
?>
