<?php 

// Fonctions liées à la session

function isConnected() {
    // Rôle : savoir si quelqu'un est connecté ou pas
    // Retour : true si connexion active, false sinon
    // Paramètres : néant
    if (!empty($_SESSION["id"])) {
        $utilisateur = new utilisateur($_SESSION["id"]);
        if ($utilisateur->get("active") == 2) {
            return true;
        }
    } else {
        return false;
    }
}

function utilisateurConnecte() {
    // Rôle : Récupérer l'utilisateur connecté
    // Retour : un objet utilisateur, chargé avec utilisateur connecté si on est connecté, non chargé sinon
    // Paramètres : néant
    $utilisateur = new utilisateur();
    if (isConnected()) {
        $utilisateur->loadById($_SESSION["id"]);
    }
    return $utilisateur;
    

}

function deconnecter() {
    // Rôle : fermer la connexion courante
    // Retour : néant
    // Paramètre : néant
    $_SESSION["id"] = 0;
}

function connecter ($pseudo, $password) {
    // Rôle : vérifier des codes de connexion et établir la connexion si ok, la fermer sinon
    // Retour : true si on a établit la connexion, false sinon
    // Paramètres :
    //      $pseudo : pseudo de connexion à tester
    //      $password : mot de passe à envoyer
    $utilisateur = new utilisateur();
    if (!$utilisateur->loadByPseudo($pseudo)) {
        deconnecter();
        return false;    
    }

    if (!password_verify($password, $utilisateur->get("password"))) {
        deconnecter();
        return false;
    }
    if ($utilisateur->active == 1) {
        deconnecter();
        return false;
    }

    $_SESSION["id"] = $utilisateur->id();
    return true;
}