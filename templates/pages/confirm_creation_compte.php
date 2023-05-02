<?php
/*
Template de page : Mise en forme de la page d'activation du compte
Paramètres : 
        $utilisateur : objet utilisateur courant
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/fragments/head.php" ?>
    <title>Activation de compte</title>
</head>

<body>
    <main>
        <h1>Activation de compte</h1>
        <p>Félicitations <?= $utilisateur->pseudo ?>,</p>
        <p>vous avez créé un compte sur les "ptites zannonces", vous avez reçu un mail, veuillez cliquer sur le lien fournit pour activer votre compte.</p>
    </main>
    <?php include "templates/fragments/footer.php" ?>
</body>

</html>