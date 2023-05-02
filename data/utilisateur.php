<?php 

// Classe utilisateur : manipuler l'objet utilisateur

class utilisateur extends _model {
    protected $champs = ["pseudo"=>"string", "password"=>"string", "email"=>"string", "active"=>"number", "code_activation"=>"string"];
    protected $table = "utilisateur";
    protected $champsNomComplet = ["pseudo"];


    // Fonctions publiques


    public function getAllAnnonces() {
        // Rôle : Récupère toutes les annonces non vendu
        // Retour : tableau d'objets de la classe annonces, 
        // Paramètres : néant
        $annonce = new annonce();
        return $annonce->getAllAnnonces($this->id);
    }

    public function getSelfAnnonces() {
        // Rôle : récupère la liste des annonces de l'utilisateur connecté
        // Retour : tableau d'objets annonces
        // Paramètres : néant
        $annonce = new annonce();
        return $annonce->getSelfAnnonces($this->id);
    }


    public function getOffreSelfAnnonces() {
        // Rôle : récupère la liste des annonces de l'utilisateur connecté
        // Retour : tableau des offres correspondant aux annonces de l'utilisateur connecté
        // Paramètres : néant
        $offre = new offre();
        return $offre->getOffreSelfAnnonces($this->id);

    }

    public function getSelfOffres() {
        // Rôle : récupère la liste des offres de l'utilisateur connecté
        // Retour : tableau d'objets offres
        // Paramètres : néant 
        $offre = new offre();
        return $offre->getSelfOffres($this->id);
    }
    public function getSelfOffresVue() {
        // Rôle : récupère la liste des offres de l'utilisateur connecté
        // Retour : tableau d'objets offres
        // Paramètres : néant 
        $offre = new offre();
        return $offre->getSelfOffresVue($this->id);
    }


    public function getAnnoncesFiltrer($tab) {
        // Rôle : récupère la liste des annonces filtrer selon ce que contient $tab
        // Retour : tableau d'objets annonces
        // Paramètres :
        //      $tab : tableau contenant les valeurs de mot-cle, prix-min, prix-max et date
        $annonce = new annonce();
        return $annonce->getAnnoncesFiltrer($tab);
    }

    public function genererMailOffre($idAnnonce) {
        // Rôle : Envoie un mail au vendeur le prevenant qu'une offre à été faite
        // Retour : néant
        // Paramètres : néant
        $annonce = new annonce($idAnnonce);

        $sujet = "Vous avez reçu une offre pour ". $annonce->html("titre");
        global $mailTest;
        $destMail = $mailTest;
        $destNom = $annonce->html("vendeur");
        $message = "
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf8'>
        </head>
        <body>
            <p>Bonjour ". $annonce->html("vendeur").",</p>
            <p>Vous avez reçu une offre pour votre annonce : " . $annonce->html("titre") ."</p>
        </body>
        </html>";
        $entete = [];
        // FROM
        $entete["from"] = "'Les ptites zannonces' <mywebecom@mywebecom.ovh>";

        // REPLY TO
        $entete["Reply-To"] = "'Les ptites zannonces' <contact@ptiteszannonces.com>";
        // Mail html
        $entete["MIME-version"] = "1.0";
        $entete["Content-Type"] = "text/html; charset=utf8";
        $destinataire = "'".$destNom."' " . "<$destMail>";
        mail($destinataire, $sujet, $message, $entete);
    }

    public function genererMailAccepter($offre) {
        // Rôle : envoie un mail à l'acheteur pour l'offre accepter
        // Retour : néant
        // Paramètres :
        //      $offre : objet offre donné
        $sujet = "Offre accepté";
        global $mailTest;
        $destMail = $mailTest;
        $destNom = $offre->html("acheteur");
        $message = "
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf8'>
        </head>
        <body>
            <p>Bonjour ". $offre->html("acheteur").",</p>
            <p>Votre offre pour " . $offre->html("annonce") . " a été accepté</p>
        </body>
        </html>";
        $entete = [];
        // FROM
        $entete["from"] = "'Les ptites zannonces' <mywebecom@mywebecom.ovh>";

        // REPLY TO
        $entete["Reply-To"] = "'Les ptites zannonces' <contact@ptiteszannonces.com>";
        // Mail html
        $entete["MIME-version"] = "1.0";
        $entete["Content-Type"] = "text/html; charset=utf8";
        $destinataire = "'".$destNom."' " . "<$destMail>";
        mail($destinataire, $sujet, $message, $entete);
    }


    public function genererMailCompte() {
        // Rôle : Envoie un mail d'activation de compte
        // Retour : néant
        // Paramètre : néant
        $sujet = "Activation du compte";
        global $mailTest;
        $destMail = $mailTest;
        $destNom = $this->get("pseudo");
        $message = "
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf8'>
        </head>
        <body>
            <p>Bonjour ". $this->get("pseudo").",</p>
            <p>Vous avez créé un compte, cliquez sur le lien suivant pour l'activer : </p>
            <a href='http://annonces.xcauvin.mywebecom.ovh/activer_compte.php?code=". $this->get("code_activation")."&id=". $this->id()."'>Activez votre compte</a>
        </body>
        </html>";
        $entete = [];
        // FROM
        $entete["from"] = "'Les ptites zannonces' <mywebecom@mywebecom.ovh>";

        // REPLY TO
        $entete["Reply-To"] = "'Les ptites zannonces' <contact@ptiteszannonces.com>";
        // Mail html
        $entete["MIME-version"] = "1.0";
        $entete["Content-Type"] = "text/html; charset=utf8";
        $destinataire = "'".$destNom."' " . "<$destMail>";
        mail($destinataire, $sujet, $message, $entete);
    }


    public function creationCompte($post) {
        // Rôle : Créer un utilisateur dans la BDD et hache son mot de passe
        // Retour : néant
        // Paramètres :
        //      $post : $_POST envoyer pas le formulaire de creation
        if ($this->verifPassword($post["password"], $post["password2"]) && $this->verifPseudo($post["pseudo"]) && $this->verifMail($post["email"])) {
            $this->loadFromArray($post);
            $this->set("password", password_hash($post["password"], PASSWORD_DEFAULT));
            $this->set("active", 1);
            $this->genererCode();
            $this->insert();
        } else {
            echo "Format de pseudo ou mot de passe invalide";
            exit;
        }
    }

    public function loadByPseudo($pseudo) {
        // Rôle : charge l'objet utilisateur par le pseudo donné
        // Retour : true si réussi, false sinon
        // Paramètres : 
        //      $pseudo : pseudo donné
        $champs = $this->makeChampsSelect();
        $sql = "SELECT `id`, $champs FROM `$this->table` WHERE `pseudo` = :pseudo";

        $req = $this->executeRequest($sql, [":pseudo"=>$pseudo]);
        if (!$this->verifierReq($req)) {
            return false;
        }
        $tab = $req->fetch(PDO::FETCH_ASSOC);
        if (empty($tab)) {
            return false;
        }
        $this->loadFromArray($tab);
        $this->id = $tab["id"];
        return true;
    }

    // Fonctions protégées

    protected function verifMail($email) {
        // Rôle : vérifie que le format de mail est valide
        // Retour : true ou false
        // Paramètres :
        //      $mail : email donné
        if (empty($email)) {
            return false;
        }
        // Expression régulière pour valider l'adresse email
        $regExp = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/";
        return preg_match($regExp, $email);
    }


    protected function verifPseudo($pseudo) {
        // Rôle : Vérifie que le pseudo contient au moins 3 caractères de type lettre, chiffres, - ou _
        // Retour true ou false
        // Paramètres
        //      $pseudo
        if (strlen($pseudo) < 3) {
            return false;
        }
        return preg_match("/^[a-zA-Z0-9_-]{3,20}$/", $pseudo);
        
    }


    protected function verifPassword($password, $pass) {
        // Rôle : Vérifie que le mot de passe contient au moins 4 caractères, 1 lettre, 1 chiffre.
        // Retour true ou false
        // Paramètres :
        //      $password : mot de passe, donné
        //      $pass : mot de passe de confirmation
        if (strlen($password) < 4) {
            return false;
        }
        if (!preg_match("/[a-zA-Z]/", $password) || !preg_match("/[0-9]/", $password)) {
            return false;
        }
        if ($password != $pass) {
            echo $pass;
            echo $password;
            return false;
        }
        return true;
    }

    protected function genererCode() {
        // Rôle : Générer un code à 8 caractère et le charger dans l'utilisateur courant
        // Retour : néant
        // Paramètre : néant
        $caractere = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        $code = "";
        for ($i = 0; $i < 8; $i++) {
            $code .= $caractere[rand(0, strlen($caractere) -1)];
        }
        $this->set("code_activation", $code);
    }
}