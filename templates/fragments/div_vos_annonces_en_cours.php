<?php 
/*
Template de fragment : Mise en forme du contenu de la div annonces en cours
Paramètres : 
        $annonce : objet annonce donné
*/
$offres = $annonce->getOffres();
?>
<tr>
    <td><?= $annonce->titre ?></td>
    <td><?= count($offres) ?></td>
    <td><?= $annonce->prix_mini ?></td>
</tr>