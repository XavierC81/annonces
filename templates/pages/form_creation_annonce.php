<?php
/*
Template de page : Mise en forme du formulaire de création d'annonce
Paramètres : néant
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/fragments/head.php" ?>
    <title>Créer une annonce</title>
</head>

<body>
    <?php include "templates/fragments/header.php" ?>
    <main>
        <h1>Créer une annonce</h1>
        <form action="creer_annonce.php" enctype="multipart/form-data" method="post">
            <label>
                Titre de l'annonce : 
                <input type="text" name="titre">
            </label>
            <label>
                Description : 
                <textarea name="description" cols="30" rows="10"></textarea>
            </label>
            <label>
                Envoyer une photo : 
                <input type="file" name="photo">
            </label>
            <label>
                Prix minimum : 
                <input type="number" name="prix_mini" step="0.01">
            </label>
            <input type="submit" value="Créer">
        </form>
    </main>
    <?php include "templates/fragments/footer.php" ?>
</body>


</html>