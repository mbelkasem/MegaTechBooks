<?php
function getBillet($billetId) {
    // Connexion à la base de données
    $connexion = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

    // Récupérer les informations du billet depuis la base de données
    $requete = $connexion->prepare('SELECT * FROM billets WHERE id = :id');
    $requete->bindParam(':id', $billetId);
    $requete->execute();
    $billet = $requete->fetch(PDO::FETCH_ASSOC);

    return $billet;
}

function ajouterCommentaire($billetId, $commentaire) {
    // Connexion à la base de données
    $connexion = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

    // Insérer le nouveau commentaire dans la base de données
    $requeteInsertion = $connexion->prepare('INSERT INTO commentaires (billet_id, commentaire) VALUES (:billetId, :commentaire)');
    $requeteInsertion->bindParam(':billetId', $billetId);
    $requeteInsertion->bindParam(':commentaire', $commentaire);
    $requeteInsertion->execute();
}
?>
