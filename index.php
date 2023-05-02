<?php 
// controleur Préparer et afficher la page d'accueil
// Paramètre : néant

// Initialisation 
include "library/init.php";
// Connexion
if (! empty($_POST)) {
    connecter($_POST["pseudo"], $_POST["password"]);
    $utilisateur = utilisateurConnecte();
}
if (! isConnected()) {
    include "templates/pages/form_connexion.php";
    exit;
} else {
    $utilisateur = utilisateurConnecte();
}

// Analyse de la demande
$annonces = $utilisateur->getAllAnnonces();

// Intéraction BDD / objet

// Affichage
include "templates/pages/liste_annonces.php";

?>
