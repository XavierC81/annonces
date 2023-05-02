<?php
/*
Template de fragment : Mise en forme des offres de l'utilisateur connecté
Paramètres : 
        $offre : objet offre
*/
if ($offre->statut == 1) {
    $statut = "En attente";
} else if ($offre->statut == 2) {
    $statut = "accepté";
} else {
    $statut = "refusé";
}
?>
<p>Offre de <?=$offre->prix?>€ sur <?= $offre->annonce ?>, statut : <?= $statut ?> <span data-qui="acheteur" data-id="<?= $offre->id() ?>" class="remove-offer">  X</span></p>