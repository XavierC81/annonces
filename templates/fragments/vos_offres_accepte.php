<?php 
/*
Template de fragment : Mise en forme d'une ligne tr pour une offre en attente
Paramètre :
        $offre : objet offre donné
*/

?>
<tr>
    <td><?= $offre->annonce ?></td>
    <td><?= $offre->prix ?>€</td>
    <td>Accepté</td>
    <td><a href="mailto:<?= $offre->get("annonce")->get("vendeur")->html("email") ?>"><?= $offre->get("annonce")->get("vendeur")->html("email") ?></a></td>
</tr>