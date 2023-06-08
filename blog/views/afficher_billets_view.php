<!DOCTYPE html>
<html>
<head>
    <title>Afficher les billets</title>
</head>
<body>
    <h1>Blog</h1>

    <?php foreach ($billets as $billet): ?>
        <h2><?php echo $billet['titre']; ?></h2>
        <p><?php echo $billet['texte']; ?></p>
        <a href="gerer_commentaires.php?id=<?php echo $billet['id']; ?>">Voir les commentaires</a>
        <hr>

        <?php
        // Vérifier si l'utilisateur est authentifié en tant qu'administrateur ou utilisateur authentifié
        if (isset($_SESSION['admin']) || isset($_SESSION['user'])) {
            // Afficher le formulaire d'ajout de commentaires
            echo '<form method="POST" action="ajouter_commentaire.php?id='.$billet['id'].'">';
            echo '<label for="commentaire">Commentaire :</label><br>';
            echo '<textarea id="commentaire" name="commentaire" rows="4" cols="50" required></textarea><br>';
            echo '<input type="submit" value="Ajouter">';
            echo '</form>';
        }
        ?>

    <?php endforeach; ?>
</body>
</html>
