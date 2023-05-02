document.addEventListener("DOMContentLoaded", function () {
    // Si le formulaire "creation-compte" existe, on pose des écoutes sur les champs pour les vérifications et une sur le submit
    if (document.querySelector("#creation-compte") != null) {
        let form = document.querySelector("#creation-compte");
        form.pseudo.addEventListener("change", verifPseudoCompte);
        form.password.addEventListener("change", verifPassword);
        form.email.addEventListener("change", verifEmail);
        form.password2.addEventListener("change", verifConfirmPassword);
        form.addEventListener("submit", function (e) {
            e.preventDefault;
            if (verifConfirmEmail() && verifEmail() && verifPassword() && verifPseudoCompte) {
                form.submit();
            }
        });
    };
    setInterval(miseAJourTableauDeBord, 10000);
    // On pose une ecoute sur les formulaire d'offres pour les annonces
    let formOffre = document.querySelectorAll(".faire-offre");
    for (let i = 0; i < formOffre.length; i++) {
        formOffre[i].addEventListener("submit", function (e) {
            e.preventDefault();
        });
        formOffre[i].addEventListener("click", faireOffre);
    };

    // On pose une écoute sur les boutons pour accepter ou refuser les offres
    let choixOffre = document.querySelectorAll(".statut-offre");
    for (let i = 0; i < choixOffre.length; i++) {
        choixOffre[i].addEventListener("click", statutOffre);
    };

    // On pose une écoute sur les X pour retirer les offres du tableau de bord
    rechargeTableauDeBord();
})


function rechargeTableauDeBord() {
    // Rôle : On pose une écoute sur les X pour retirer les offres du tableau de bord
    // Retour : néant
    // Paramètre : néant
    let croixOffre = document.querySelectorAll(".remove-offer");
    for (let i = 0; i < croixOffre.length; i++) {
        croixOffre[i].addEventListener("click", retireOffreTableauDeBord);
    };
}


// Fonctions formulaire

function verifConfirmPassword() {
    // Rôle : vérifie que les mots de passe soient identiques
    // Retour : true ou false
    // Paramètres : néant
    
    let small = this.nextElementSibling;
    let password = document.querySelector("#creation-compte").password
    if (password.value != this.value) {        
        small.innerHTML = "Les mots de passe doivent être identique";
        small.style.color = "red";
        return false;
    } else {                
        small.innerHTML = "Les mots de passe sont identiques";
        small.style.color = "green";
        return true;
    }
}

function verifEmail() {
    // Rôle : Vérifier le champ email 
    // Retour : néant
    // Paramètres : néant
    let emailRegEx = new RegExp('^[a-zA-Z0-9.-_]+[@]{1}[a-zA-Z0-9.-_]+[.]{1}[a-z]{2,10}$');

    // On test si la valeur entré est juste ou fausse
    let testEmail = testFormat(emailRegEx, this.value);

    // On récupère l'élément small dans une variable
    let small = this.nextElementSibling;


    // On rempli le champs small
    return testchamps(testEmail, small);
}

function verifPassword() {
    // Rôle : Vérifier le champ password 
    // Retour : néant
    // Paramètres : néant
    //  On récupère l'élément small dans une variable
    let small = this.nextElementSibling;

    // Si le mot de passe à moins de 8 caractères
    if (this.value.length < 4) {
        // On affiche "le mot de passe doit contenir au moins 4 caractères"
        small.innerHTML = "Le mot de passe doit contenir au moins 4 caractères"
        small.style.color = "red"
        return false
    } else if (!/[0-9]/.test(this.value)) {
        // Sinon si le mot de passe ne contient pas de nombre
        // On affiche "le mot de passe doit contenir au moins un nombre"
        small.innerHTML = "Le mot de passe doit contenir au moins un nombre"
        small.style.color = "red"
        return false
    } else if (!/[a-zA-Z]/.test(this.value)) {
        // Sinon si le mot de passe ne contient pas de minuscule
        // On affiche "le mot de passe doit contenir au moins une minuscule"
        small.innerHTML = "Le mot de passe doit contenir au moins une lettre"
        small.style.color = "red"
        return false
    } else {
        // Sinon, le format est valide
        small.innerHTML = "Format valide"
        small.style.color = "green"
        return true
    }
}

function verifPseudoCompte() {
    // Rôle : Vérifier le champ pseudo 
    // Retour : néant
    // Paramètres : néant

    // Créer une regExp pour la validation du pseudo
    let pseudoRegEx = new RegExp("^[A-Za-zÀÆàéèçêïîëÇÉÈŒœÙù]{1}[a-zéèàçêëîïæœèù]*([\s'-]{1}[A-Za-zÀÆàéèçêïîëÇÉÈŒœÙù]{1}[a-zéèàçêëîïæœè7ù]*)?$");

    // On test si la valeur entré est juste ou fausse
    let testPseudo = testFormat(pseudoRegEx, this.value);

    // On récupère l'élément small dans une variable
    let small = this.nextElementSibling;


    // On rempli le champs small
    return testchamps(testPseudo, small);
}




function testFormat(condition, valeur) {
    // Rôle : Test si une valeur correspond à la condition
    // Retour : true ou false
    // Paramètre : 
    //      condition : les conditions à respecter
    //      valeur : la valeur à tester
    return condition.test(valeur);
}


function testchamps(test, small) {
    // Rôle : Remplit le champs small en fonction du booléen 
    // Retour : true ou false
    //Paramètre:
    //      test : true ou false
    //      small : le champ à remplir

    if (test == true) {
        small.innerHTML = "Format valide";
        small.style.color = "";
        small.style.color = "green";
        return true
    } else {
        small.innerHTML = "Format non valide";
        small.style.color = "";
        small.style.color = "red";
        return false
    }
}


// Fonctions AJAX

function miseAJourTableauDeBord() {
    // Rôle : mettre à jour le tableau de bord
    // Retour : néant
    // Paramètres : néant
    let url = "afficher_offres_non_vue.php";
    $.ajax(url, {
        type: "GET",
        success: finaliseTableauDeBord,
        error: function () {
            console.error("erreur de communication")
        }
    })
}

function retireOffreTableauDeBord() {
    // Rôle : change l'attribut vue d'une offre
    // Retour : néant
    // Paramètres : néant
    let id = this.dataset.id;
    let qui = this.dataset.qui;
    let url = `enlever_offre_vue.php?id=${id}&qui=${qui}`;
    $.ajax(url, {
        type: "GET",
        success: finaliseTableauDeBord,
        error: function () {
            console.error("erreur de communication")
        }
    })
}

function faireOffre() {
    // Rôle : Créer une offre et génère un mail au vendeur
    // Retour : néant
    // Paramètres : 
    //      id : id de l'annonce donnée
    let id = this.dataset.id;
    let url = `creer_offre.php?id=${id}`;
    let prixPropose = this.prix.value;
    let formData = { prix: prixPropose, annonce: id };
    $.ajax(url, {
        type: "POST",
        data: formData,
        success: finaliseTableauDeBord,
        error: function () {
            console.error("erreur de communication")
        }
    })
}

function statutOffre() {
    // Rôle : changer le statut d'une offre et génère un mail à l'acheteur
    // Retour : néant
    // Paramètres : 
    let action = this.dataset.action;
    let id = this.dataset.id;
    let url = `generer_mail_statut_offre.php?id=${id}&action=${action}`;
    $.ajax(url, {
        type: "GET",
        success: finaliseStatutOffre,
        error: function () {
            console.error("erreur de communication")
        }
    })
}

function finaliseStatutOffre(data) {
    // Rôle : mettre à jour le statut de l'offre dans l'endroit ciblé
    // Retour : néant
    // Paramètres : 
    //      data : données reçu du controleur php
    $("#liste-offre").html(data);
}

function finaliseTableauDeBord(data) {
    // Rôle : mettre à jour le tableau de bord
    // Retour : néant
    // Paramètres : 
    //      data : données reçu du controleur php
    $("#tableau-de-bord").html(data);
    rechargeTableauDeBord();
}