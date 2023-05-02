<?php
/*
Template de page : Mise en forme de la page annonces de l'utilisateur connecté
Paramètres : 
        $annonces : tableau d'objets de la classe annonce
*/
$annoncePourTest = new annonce();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/fragments/head.php" ?>
    <title>Vos annonces</title>
</head>

<body>
    <?php include "templates/fragments/header.php" ?>
    <main class="flex">
        <div class="large-75">
            <h1>Vos annonces</h1>
            <div>
                <h2>Annonces en cours</h2>
                <?php
                if (!$annoncePourTest->nombreAnnonce($annonces, 1)) {
                    echo "<p>Vous n'avez pas d'annonces terminées</p>";
                } else {
                    echo "<table><tr><th>Titre de l'annonce</th><th>Nombre d'offres</th><th>Prix minimum</th></tr>";
                    if (!$annoncePourTest->nombreAnnonce($annonces, 1)) {
                        echo "<p>Vous n'avez pas d'annonces en cours</p>";
                    } else {
                        foreach ($annonces as $annonce) {
                            if ($annonce->vente == 1) {
                                include "templates/fragments/div_vos_annonces_en_cours.php";
                            }
                        }
                    }
                    echo "</table>";
                }
                ?>
            </div>
            <div>
                <h2>Annonces terminées</h2>
                <?php
                if (!$annoncePourTest->nombreAnnonce($annonces, 2)) {
                    echo "<p>Vous n'avez pas d'annonces terminées</p>";
                } else {
                    echo "<table><tr><th>Titre de l'annonce</th><th>Prix vendu</th><th>Email de l'acheteur</th></tr>";
                    foreach ($annonces as $annonce) {
                        if ($annonce->vente == 2) {
                            include "templates/fragments/div_vos_annonces_terminees.php";
                        }
                        echo "</table>";
                    }
                }
                ?>
            </div>
        </div>
        <div class="large-25"><?php include "templates/fragments/tableau_de_bord.php" ?></div>
    </main>
    <?php include "templates/fragments/footer.php" ?>
</body>


</html>