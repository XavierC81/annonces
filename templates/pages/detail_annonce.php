<?php
/*
Template de page : Mise en forme du détail d'une annonce
Paramètres : 
        $annonce : objet courant de la classe annonce
*/
$offres = $annonce->getOffres();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/fragments/head.php" ?>
    <title><?= $annonce->titre ?></title>
</head>

<body>
    <?php include "templates/fragments/header.php" ?>
    <main class="flex">
        <div class="large-75">
            <h1><?= $annonce->titre ?></h1>
            <p>Publié le <?= $annonce->date_annonce ?></p>
            <div class="flex justify-between">
                <div class="large-50">
                    <div class="large-100">
                        <img src="<?= $annonce->get("photo") ?>">
                    </div>
                </div>
                <div class="large-50">
                    <p><?= $annonce->description ?></p>
                    <p>Prix minimum : <?= $annonce->prix_mini ?>€</p>
                </div>
            </div>
            <h2>Offres</h2>
            <div id="liste-offre">
                <?php include "templates/fragments/liste_offre.php" ?>
            </div>
        </div>
        <div class="large-25">
            <?php include "templates/fragments/tableau_de_bord.php" ?>
        </div>
    </main>
    <?php include "templates/fragments/footer.php" ?>
</body>


</html>