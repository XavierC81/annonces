<?php 
/*
Template de fragment : Mise en forme d'une offre concernant une annonce
Paramètres : 
        $offre : objet de la classe offre
*/
?><div class="flex space-between">
    <p>Offre à <?= $offre->prix ?>€</p>
    <span class="btn statut-offre" data-action="accepter" data-id="<?= $offre->id() ?>">Accepter</span>
    <span class="btn statut-offre" data-action="refuser" data-id="<?= $offre->id() ?>">Refuser</span>
</div>