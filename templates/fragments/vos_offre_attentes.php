<?php 
/*
Template de fragment : Mise en forme d'une ligne tr pour une offre refusé
Paramètre :
        $offre : objet offre donné
*/

?>
<tr>
    <td><?= $offre->annonce ?></td>
    <td><?= $offre->prix ?>€</td>
    <td>En attente</td>
</tr>