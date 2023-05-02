<?php
/*
Template de fragment : Mise en forme du contenu d'une div décrivant les annonces
Paramètres :
        $annonces : tableau d'objets annonce
*/
?>
<h2>Liste des annonces</h2>
<?php
foreach ($annonces as $annonce) {
    include "templates/fragments/detail_annonce.php";
}
?>