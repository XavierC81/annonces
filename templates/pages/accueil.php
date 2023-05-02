<?php
/*
Template de page : Mise en forme de la page d'accueil
Paramètres : 
        $annonces : liste des annonces non vendu
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/fragments/head.php" ?>
    <title>Accueil</title>
</head>

<body>
    <?php include "templates/fragments/header.php" ?>
    <main class="flex">
        <div class="large-75">
            <h1>Accueil les ptites zannonces</h1>
            <a href="afficher_form_creation_annonce.php" class="btn">Créer annonce</a>
            <h2>Chercher des annonces</h2>
            <?php 
            include "templates/fragments/recherche_accueil.php";
            ?>
            <div>
                <?php include "templates/fragments/div_liste_annonces.php"?>
            </div>
        </div>
        <div class="large-25"><?php include "templates/fragments/tableau_de_bord.php" ?></div>

    </main>
    <?php include "templates/fragments/footer.php" ?>
</body>

</html>