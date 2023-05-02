<?php
/*
Template de page : Mise en forme de la page listant les offres de l'utilisateur connecté
Paramètres : 
        $offres : tableau d'objets de la classe offre
*/
$offrePourTest = new offre();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/fragments/head.php" ?>
    <title>Vos offres</title>
</head>

<body>
    <?php include "templates/fragments/header.php" ?>
    <main class="flex">
        <div class="large-75">
            <h1>Vos offres</h1>
            <div>
                <h2>Offres en attente</h2>
                <?php
                if (!$offrePourTest->nombreOffre($offres, 1)) {
                    echo "<p>Vous n'avez pas d'offres en attente</p>";
                } else {
                    echo "<table><tr><th>Titre de l'annonce</th><th>Prix proposé</th><th>Statut</th></tr>";
                    foreach ($offres as $offre) {
                        if ($offre->get("statut") == 1) {
                            include "templates/fragments/vos_offre_attentes.php";
                        }
                    }
                    echo "</table>";
                }
                ?>
            </div>
            <div>
                <h2>Offres acceptées</h2>
                <?php
                if (!$offrePourTest->nombreOffre($offres, 2)) {
                    echo "<p>Vous n'avez pas d'offres acceptées</p>";
                } else {
                    echo "<table>
                    <tr>
                        <th>Titre de l'annonce</th>
                        <th>Prix proposé</th>
                        <th>Statut</th>
                        <th>Email du vendeur</th>
                    </tr>";
                    foreach ($offres as $offre) {
                        if ($offre->get("statut") == 2) {
                            include "templates/fragments/vos_offres_accepte.php";
                        }
                    }
                    echo "</table>";
                }
                ?>
            </div>
            <div>
                <h2>Offres refusées</h2>
                <?php
                if (!$offrePourTest->nombreOffre($offres, 3)) {
                    echo "<p>Vous n'avez pas d'offres refusées</p>";
                } else {
                    echo "<table>
                    <tr>
                        <th>Titre de l'annonce</th>
                        <th>Prix proposé</th>
                        <th>Statut</th>
                    </tr>";
                    foreach ($offres as $offre) {
                        if ($offre->get("statut") == 3) {
                            include "templates/fragments/vos_offres_refuse.php";
                        }
                    }
                    echo "</table>";
                }
                ?>
            </div>
        </div>
        <div class="large-25"><?php include "templates/fragments/tableau_de_bord.php" ?></div>
    </main>
    <?php include "templates/fragments/footer.php" ?>
</body>


</html>