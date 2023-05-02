<?php 
/*
Template de fragment : Mise en forme du contenu de la div annonces en cours
Paramètres : 
        $annonce : objet annonce donné
*/
$offres = $annonce->getOffresTermine();
?>
<tr>
    <td><?= $annonce->titre ?></td>
    <td><?php
        foreach ($offres as $offre) {
            if ($offre->value("annonce") == $annonce->id()) {
                echo $offre->get("prix") . "€";
            }
        }
    ?></td><?php
    foreach ($offres as $offre) {
        if ($offre->value("annonce") == $annonce->id()) {
            echo "<td><a href='mailto:" . $offre->get('acheteur')->html('email') . "'>" . $offre->get('acheteur')->html('email') . "</a></td>";
        }
    }
    ?>
    
</tr>