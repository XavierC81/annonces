<?php
/*
Template de page : 
Paramètres : 
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/fragments/head.php" ?>
    <title>Créer un compte</title>
</head>

<body>
    <main>
        <h1>Créer un compte</h1>
        <form action="generer_mail_activation.php" id="creation-compte" method="post">
            <label>
                Pseudo :
                <input type="text" name="pseudo">
                <small></small>
            </label>
            <label>
                Mot de passe :
                <input type="password" name="password">
                <small></small>
            </label>
            <label>
                Confirmer votre mot de passe :
                <input type="password" name="password2">
                <small></small>
            </label>
            <label>
                Email :
                <input type="email" name="email">
                <small></small>
            </label>
            <input type="submit" value="Créer">
        </form>
    </main>
    <?php include "templates/fragments/footer.php" ?>
</body>

</html>