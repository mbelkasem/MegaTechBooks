<?php
// Connexion à la base de données
$connexion = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

// Récupérer les billets du blog depuis la base de données
$requete = $connexion->query('SELECT * FROM billets ORDER BY id DESC');
$billets = $requete->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire d'ajout de billet
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $texte = $_POST['texte'];

    // Vérifier si les champs sont remplis
    if (!empty($titre) && !empty($texte)) {
        // Insérer le nouveau billet dans la base de données
        $requeteInsertion = $connexion->prepare('INSERT INTO billets (titre, texte) VALUES (:titre, :texte)');
        $requeteInsertion->bindParam(':titre', $titre);
        $requeteInsertion->bindParam(':texte', $texte);
        $requeteInsertion->execute();
    }
}

// Traitement de la recherche
if (isset($_GET['q'])) {
    $recherche = $_GET['q'];

    // Requête de recherche des billets
    $requeteRecherche = $connexion->prepare('SELECT * FROM billets WHERE titre LIKE :recherche');
    $requeteRecherche->bindValue(':recherche', '%' . $recherche . '%');
    $requeteRecherche->execute();
    $billets = $requeteRecherche->fetchAll(PDO::FETCH_ASSOC);
}

// Retourner les données à utiliser dans le contrôleur
return [
    'billets' => $billets
];
?>
