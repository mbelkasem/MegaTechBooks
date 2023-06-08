<!DOCTYPE html>
<html>
<head>
    <title>Modifier un billet</title>
</head>
<body>
    <h1>Modifier un billet</h1>

    <form method="POST" action="editer_billet_controller.php">
        <input type="hidden" name="billet_id" value="<?php echo $billet['id']; ?>">

        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" value="<?php echo $billet['titre']; ?>" required><br><br>

        <label for="texte">Texte :</label>
        <textarea id="texte" name="texte" rows="4" cols="50" required><?php echo $billet['texte']; ?></textarea><br><br>

        <input type="submit" value="Enregistrer les modifications">
    </form>
</body>
</html>
