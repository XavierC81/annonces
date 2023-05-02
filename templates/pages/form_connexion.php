<?php
/*
Template de page : Mise en forme du formulaire de connexion
Paramètres : néant
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/fragments/head.php" ?>
    <title>Connexion</title>
</head>

<body>
    <main>
        <h1>Connexion</h1>
        <form action="index.php" method="post">
            <label>
                Pseudo : 
                <input type="text" name="pseudo">
            </label>
            <label>
                Mot de passe : 
                <input type="password" name="password">
            </label>
            <input type="submit" value="Se connecter">
        </form>
        <a href="afficher_form_creation_utilisateur.php" class="btn">Créer compte</a>
    </main>
    <?php include "templates/fragments/footer.php" ?>
</body>

</html>