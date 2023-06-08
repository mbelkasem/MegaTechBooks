<?php
session_start();

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
    // Rediriger vers une page d'erreur ou une page de connexion
    header("Location: erreur.php");
    exit;
}

// Récupérer l'identifiant du billet pour lequel ajouter un commentaire
$billetId = $_GET['id'];

// Connexion à la base de données
$connexion = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

// Récupérer les informations du billet depuis la base de données
$requete = $connexion->prepare('SELECT * FROM billets WHERE id = :id');
$requete->bindParam(':id', $billetId);
$requete->execute();
$billet = $requete->fetch(PDO::FETCH_ASSOC);

// Vérifier si le billet existe
if (!$billet) {
    // Rediriger vers une page d'erreur ou une page de gestion des billets
    header("Location: erreur.php");
    exit;
}

// Traitement du formulaire d'ajout de commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentaire = $_POST['commentaire'];

    // Vérifier si le champ est rempli
    if (!empty($commentaire)) {
        // Insérer le nouveau commentaire dans la base de données
        $requeteInsertion = $connexion->prepare('INSERT INTO commentaires (billet_id, commentaire) VALUES (:billetId, :commentaire)');
        $requeteInsertion->bindParam(':billetId', $billetId);
        $requeteInsertion->bindParam(':commentaire', $commentaire);
        $requeteInsertion->execute();

        // Rediriger vers la page de gestion des commentaires
        header("Location: gerer_commentaires.php?id=".$billetId);
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un commentaire</title>
</head>
<body>
    <h1>Ajouter un commentaire</h1>
    <h2>Billet : <?php echo $billet['titre']; ?></h2>
    <p><?php echo $billet['texte']; ?></p>

    <form method="POST" action="">
        <label for="commentaire">Commentaire :</label><br>
        <textarea id="commentaire" name="commentaire" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" value="Ajouter le commentaire">
    </form>
</body>
</html>
