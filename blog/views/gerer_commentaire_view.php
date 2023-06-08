<!DOCTYPE html>
<html>
<head>
    <title>Gérer les commentaires</title>
</head>
<body>
    <h1>Gérer les commentaires</h1>
    <h2>Billet : <?php echo $billet['titre']; ?></h2>
    <p><?php echo $billet['texte']; ?></p>

    <h3>Commentaires :</h3>
    <?php foreach ($commentaires as $commentaire): ?>
        <h4><?php echo $commentaire['auteur']; ?></h4>
        <p><?php echo $commentaire['commentaire']; ?></p>
        <hr>
    <?php endforeach; ?>
</body>
</html>
