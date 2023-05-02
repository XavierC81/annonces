<?php 
/*
Template de fragment : Mise en forme d'une ligne tr pour une offre accepter
Paramètre :
        $offre : objet offre donné
*/

?>
<tr>
    <td><?= $offre->annonce ?></td>
    <td><?= $offre->prix ?>€</td>
    <td>Refusé</td>
</tr>