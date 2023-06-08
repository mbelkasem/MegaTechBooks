<?php
class BilletModel {
    // Méthode pour récupérer un billet depuis la base de données
    public static function getBillet($billetId) {
        // Connexion à la base de données
        $connexion = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

        // Récupération du billet depuis la base de données
        $requete = $connexion->prepare('SELECT * FROM billets WHERE id = :id');
        $requete->bindParam(':id', $billetId);
        $requete->execute();
        $billet = $requete->fetch(PDO::FETCH_ASSOC);

        return $billet;
    }

    // Méthode pour mettre à jour un billet dans la base de données
    public static function updateBillet($billetId, $nouveauTitre, $nouveauTexte) {
        // Connexion à la base de données
        $connexion = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

        // Mise à jour du billet dans la base de données
        $requete = $connexion->prepare('UPDATE billets SET titre = :titre, texte = :texte WHERE id = :id');
        $requete->bindParam(':id', $billetId);
        $requete->bindParam(':titre', $nouveauTitre);
        $requete->bindParam(':texte', $nouveauTexte);
        $requete->execute();
    }
}
?>
