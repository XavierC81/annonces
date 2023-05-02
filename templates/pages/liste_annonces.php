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
    <title>Liste des annonces</title>
</head>

<body>
    <?php include "templates/fragments/header.php" ?>
    <main class="flex">
        <div class="large-75">
            <h1>Annonces recherché</h1>
            <?php include "templates/fragments/recherche_accueil.php" ?>
            <div>
                <?php include "templates/fragments/div_liste_annonces.php" ?>
            </div>
        </div>
        <div class="large-25"><?php include "templates/fragments/tableau_de_bord.php" ?></div>
    </main>
    <?php include "templates/fragments/footer.php" ?>
</body>

</html>