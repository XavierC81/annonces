<?php 
/*
Template de fragment : Mise en forme de la liste des offres pour une annonce
Paramètres :
        $offres : tableau d'objet offre correspondant à l'annonce
        $annonce : objet annonce donné
*/
        if (!empty($offres)) {
            foreach ($offres as $offre) {
                include "templates/fragments/offre_annonce.php";
            }
        } else if ($annonce->get("vente") == 2) {
            echo "<p>Le produit de cette annonce a été vendu.</p>";
        } else {
            echo "<p>Il n'y a pas encore d'offre pour cette annonce.</p>";
        }
        ?>