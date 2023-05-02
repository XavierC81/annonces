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
    <title>Compte activé</title>
</head>

<body>
    <main>
        <h1>Compte activé</h1>
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
    </main>
    <?php include "templates/fragments/footer.php" ?>
</body>

</html>