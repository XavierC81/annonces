<?php 
/*
Template de fragment : Mise en forme du formulaire de recherche de la page d'accueil
Paramètre :
        POST : facultatif champs du formulaire
*/
if (!empty($_POST["mot-cle"])) {
    $motCle = $_POST["mot-cle"];
} else {
    $motCle = "";
}
if (!empty($_POST["prix-min"])) {
    $prixMin = $_POST["prix-min"];
} else {
    $prixMin = "";
}
if (!empty($_POST["prix-max"])) {
    $prixMax = $_POST["prix-max"];
} else {
    $prixMax = "";
}
if (!empty($_POST["date"])) {
    $date = $_POST["date"];
} else {
    $date = "";
}
?>
<form action="afficher_liste_annonces.php" method="post">
    <label class="large-100">
        Recherche par mot clé :
        <input type="text" name="mot-cle" value="<?= $motCle ?>">
    </label>
    <label class="large-50">
        Prix entre
        <input type="number" step="0.01" name="prix-min" value="<?= $prixMin ?>">
    </label>
    <label class="large-50">
        et
        <input type="number" step="0.01" name="prix-max" value="<?= $prixMax ?>"> €
    </label>
    <label class="large-100">
        Annonce publier à partir de :
        <input type="date" name="date" value="<?= $date ?>">
    </label>
    <input type="submit" class="btn" value="Rechercher">
</form>