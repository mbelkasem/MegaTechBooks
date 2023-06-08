<?php
function getBillets() {
    // Connexion à la base de données
    $connexion = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

    // Récupérer les billets du blog depuis la base de données
    $requete = $connexion->query('SELECT * FROM billets ORDER BY id DESC');
    $billets = $requete->fetchAll(PDO::FETCH_ASSOC);

    return $billets;
}
?>
