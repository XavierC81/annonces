<?php 
/*
Template de fragment : Mise en forme d'une div décrivant une annonce
Paramètres : 
        $annonce : objet annonce courant
*/
?>
<div>
    <h3><?= $annonce->titre ?></h3>
    <p>Publié le <?= $annonce->date_annonce ?></p>
    <div class="flex justify-between">
        <div class="large-50">
            <div class="large-100">
                <img src="<?= $annonce->get("photo") ?>">
            </div>            
        </div>
        <div class="large-50">
            <p><?= $annonce->description ?></p>
            <p>Prix minimum : <?= $annonce->prix_mini ?>€</p>
        </div>
    </div>
    <form action="creer_offre.php?id=<?= $annonce->id() ?>" class="faire-offre" method="post" data-id="<?= $annonce->id() ?>">
        <label>
            Prix proposé : 
            <input type="number" step="0.01" name="prix">
        </label>
        <input type="submit" class="uppercase btn" value="Faire une offre">
    </form>
</div>