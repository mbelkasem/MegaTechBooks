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

        <input type="submit" value="Ajouter le commentaire
