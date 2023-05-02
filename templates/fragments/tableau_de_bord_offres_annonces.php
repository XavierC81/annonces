<?php
/*
Template de fragment : Mise en forme des offres sur les annonces de l'utilisateur
Paramètres : 
        $offre : tableau d'offre
*/
?>
<p>Offre de <?=$offre["prix"]?>€ sur <a href="afficher_detail_annonce.php?id=<?= $offre["idAnnonce"] ?>" class="offre-tableau-lien"><?= $offre["titre"] ?></a> <span data-id="<?= $offre["idOffre"] ?>" data-qui="vendeur" class="remove-offer">  X</span></p>