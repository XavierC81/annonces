<?php
/*
Template de fragment : Mise en forme du tableau de bord
Paramètres : 
        $utilisateur : objet courant de la classe utilisateur
*/
$offresSelfAnnonces = $utilisateur->getOffreSelfAnnonces();
$selfOffres = $utilisateur->getSelfOffresVue();
?>
<p class="title">Tableau de bord</p>
    <div>
        <p class="little-title">Vos annonces</p>
        <?php
        if (!empty($offresSelfAnnonces)) {
            foreach ($offresSelfAnnonces as $offre) {
                include "templates/fragments/tableau_de_bord_offres_annonces.php";
            }
        } else {
            echo "<p>Il n'y a pas d'offres en cours sur vos annonces</p>";
        }
        ?>
    </div>
    <div>
        <p class="little-title">Vos offres</p>
        <?php
        if (!empty($selfOffres)) {
        foreach ($selfOffres as $offre) {
            include "templates/fragments/tableau_de_bord_vos_offres.php";
        }
    } else {
        echo "<p>Vous n'avez pas d'offres en cours</p>";
    }
        ?>