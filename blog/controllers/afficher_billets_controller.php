<?php
session_start();

// Inclure le modèle
include 'afficher_billets_model.php';

// Récupérer les billets
$billets = getBillets();

// Inclure la vue
include 'afficher_billets_view.php';
?>
