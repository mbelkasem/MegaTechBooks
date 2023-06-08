<?php
// Inclure le modèle
$data = include 'admin_model.php';

// Extraire les données du modèle
extract($data);

// Inclure la vue
include 'admin_view.php';
?>
