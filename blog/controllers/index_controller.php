<?php
// Inclure le modèle
$data = include 'index_model.php';

// Extraire les données du modèle
extract($data);

// Inclure la vue
include 'index_view.php';
?>
