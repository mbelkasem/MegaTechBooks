<?php
require __DIR__.'/vendor/autoload.php';

session_start();

// Vérifier si l'administrateur est déjà connecté
if (isset($_SESSION['admin'])) {
    // Rediriger vers la page de gestion des billets
    header("Location: gestion_billets.php");
    exit;
}

// Vérifier les informations d'identification lors de la soumission du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérifier les informations d'identification par rapport à la base de données
    $connexion = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
    $requete = $connexion->prepare('SELECT * FROM utilisateurs WHERE login = :username AND password = :password');
    $requete->bindParam(':username', $username);
    $requete->bindParam(':password', $password);
    $requete->execute();
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    if ($resultat) {
        // Les informations d'identification sont valides, créer une session pour l'administrateur
        $_SESSION['admin'] = $resultat['id'];
        header("Location: gestion_billets.php");
        exit;
    } else {
        // Informations d'identification incorrectes, afficher un message d'erreur
        $messageErreur = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page d'administration</title>
</head>
<body>
    <h1>Page d'administration</h1>
    <form method="POST" action="admin.php">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br>
        <input type="submit" value="Se connecter">
    </form>
    <?php if (isset($messageErreur)) { echo $messageErreur; } ?>
</body>
</html>
