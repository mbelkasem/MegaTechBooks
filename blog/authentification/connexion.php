<?php
session_start();

// Vérification des identifiants de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin123') {
        // Les identifiants sont corrects, connecter l'administrateur
        $_SESSION['admin'] = true;
        header("Location: index.php"); // Rediriger vers la page principale
        exit;
    } else {
        // Identifiants incorrects, afficher un message d'erreur
        $erreur = "Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>

    <?php if (isset($erreur)): ?>
        <p><?php echo $erreur; ?></p>
    <?php endif; ?>

    <form method="POST" action="connexion.php">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>
