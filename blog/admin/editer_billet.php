<?php
// Vérifier si l'administrateur est connecté
session_start();
if (!isset($_SESSION['admin'])) {
    // Rediriger vers une page d'erreur ou une page de connexion
    header("Location: erreur.php");
    exit;
}

// Récupérer l'identifiant du billet à éditer
$billetId = $_GET['id'];

// Connexion à la base de données
$connexion = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

// Récupérer les informations du billet à éditer depuis la base de données
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

// Traitement du formulaire d'édition de billet
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $texte = $_POST['texte'];

    // Vérifier si les champs sont remplis
    if (!empty($titre) && !empty($texte)) {
        // Mettre à jour le billet dans la base de données
        $requeteMiseAJour = $connexion->prepare('UPDATE billets SET titre = :titre, texte = :texte WHERE id = :id');
        $requeteMiseAJour->bindParam(':titre', $titre);
        $requeteMiseAJour->bindParam(':texte', $texte);
        $requeteMiseAJour->bindParam(':id', $billetId);
        $requeteMiseAJour->execute();

        // Rediriger vers la page d'affichage des billets
        header("Location: afficher_billets.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Éditer le billet</title>
</head>
<body>
    <h1>Éditer le billet</h1>
    <form method="POST" action="">
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" value="<?php echo $billet['titre']; ?>" required><br><br>
        
        <label for="texte">Texte :</label><br>
        <textarea id="texte" name="texte" rows="4" cols="50" required><?php echo $billet['texte']; ?></textarea><br><br>
        
        <input type="submit" value="Enregistrer">
    </form>
</body>
</html>
