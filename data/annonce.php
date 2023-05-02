<?php 

// Classe annonce : manipuler l'objet annonce

class annonce extends _model {
    protected $champs = ["titre"=>"string", "description"=>"string", "photo"=>"string", "vendeur"=>"link", "prix_mini"=>"number", "vente"=>"number", "date_annonce"=>"date"];
    protected $table = "annonce";
    protected $links = ["vendeur"=>"utilisateur"];
    protected $champsNomComplet = ["titre"];


    // Fonctions publique


    public function getOffres() {
        // Rôle : Récupère toutes les offres liées à l'annonce courante
        // Retour : tableau d'objets de la classe offre
        // Paramètres : néant
        $offre = new offre();
        return $offre->getOffres($this->id);
    }



    public function getOffresTermine() {
        // Rôle : Récupère toutes les offres liées à l'annonce courante
        // Retour : tableau d'objets de la classe offre
        // Paramètres : néant
        $offre = new offre();
        return $offre->getOffresTermine($this->id);
    }

    

    public function getSelfAnnonces($idVendeur) {
        // Rôle : récupère la liste des annonces de l'utilisateur connecté
        // Retour : tableau d'objets annonces
        // Paramètres : néant
        $champs = $this->makeChampsSelect();
        $sql = "SELECT `id`, $champs FROM `$this->table` WHERE `vendeur` = :vendeur ORDER BY `date_annonce` DESC";

        return $this ->listExecuteRequest($sql, [":vendeur"=>$idVendeur]);
    }


    public function getAnnoncesFiltrer($tab) {
        // Rôle : récupère la liste des annonces filtrer selon ce que contient $tab
        // Retour : tableau d'objets annonces
        // Paramètres :
        //      $tab : tableau contenant les valeurs de mot-cle, prix-min, prix-max et date
        if (empty($tab)) {
            return $this->getAllAnnonces($_SESSION["id"]);
        } else {
            $sql = "";
            $param = [];
            $result = $this->makeFiltreAnnonces($tab, $sql, $param);
            return $this->listExecuteRequest($sql, $param);
        }
    }


    public function getAllAnnonces($idUtilisateur) {
        // Rôle : Récupère toutes les annonces non vendu
        // Retour : tableau d'objets de la classe annonces, 
        // Paramètres : 
        //      $idUtilisateur : id du vendeur
        $champs = $this->makeChampsSelect();
        $sql = "SELECT `id`, $champs FROM `$this->table` WHERE `vente` = 1 AND `vendeur` != :utilisateur ORDER BY `date_annonce` DESC";
        return $this->listExecuteRequest($sql, [":utilisateur"=>$idUtilisateur]);
    }

    

    public function creerAnnonce($post, $files) {
        // Rôle : Créer une annonce dans la BDD
        // Retour : true ou false
        // Paramètres :
        //      $post : tableau de valeur correspondant aux champs (titre, description et prix_mini) de l'objet
        //      $files : tableau contenant des infos sur l'image uploader
                
        $this->loadFromArray($post);
        $this->set("vente", 1);
        $date = date("Y-m-d H:i:s");
        $this->set("date_annonce", $date);
        $this->set("vendeur", $_SESSION["id"]);
        $this->insert();
        $this->traitementPhoto($files);
        $this->update();

    }


    public function nombreAnnonce($annonces, $vente) {
        // Rôle : Vérifie si une annonce existe dans une vente donnée
        // Retour : true ou false
        // Paramètres : 
        //      $annonces : tableau d'objets annonce
        //      $vente : le statut de la vente
        $tab = [];
        foreach ($annonces as $annonce) {
            if ($annonce->get("vente") == $vente) {
                $tab[] = $annonce;
            }
        }
        if (count($tab) == 0) {
            return false;
        }
        return true;
    }


    // Fonctions protégées


    protected function traitementPhoto($img) {
        // Rôle : Traite l'upload de la photo
        // Retour : true ou false
        // Paramètres :
        //      $img : tableau contenant des infos sur l'image uploader

        // On vérifie que l'upload c'est bien passé
        if ($img["photo"]["error"] > 0) {
            return false;
        }

        // On vérifie que l'extension du fichier est autorisé
        $extAutorise = ["jpg", "jpeg", "png"];
        $extension = strtolower(substr(strrchr($img["photo"]["name"], "."), 1));
        if (! in_array($extension, $extAutorise)) {
            return false;
        }

        // On renomme et on déplace la photo dans le dossier img
        $nom = "img/photo_annonce" . $this->id . "." . $extension;
        $result = move_uploaded_file($img["photo"]["tmp_name"], $nom);
        if ($result == false) {
            return false;
        }
        $this->set("photo", $nom);
        return true;

    }


    protected function makeFiltreAnnonces($tab, &$sql, &$param) {
        // Rôle : contruire la requête SQL et le tableau de param de getAnnoncesFiltrer
        // Retour : néant
        // Paramètres :
        //    $tab : tableau contenant les valeurs de mot-cle, prix-min, prix-max et date
        if (!empty($tab["mot-cle"])) {
            $search = "%" . $tab["mot-cle"] . "%";
        } else {
            $search = "%%";
        }
        if (!empty($tab["prix-min"])) {
            $prixMin = $tab["prix-min"];
        } else {
            $prixMin = 0.01;
        }
        if (!empty($tab["prix-max"])) {
            $prixMax = $tab["prix-max"];
        } else {
            $prixMax = 10000000000;
        }
        $champs = $this->makeChampsSelect();
        $sql = "SELECT `id`, $champs FROM `$this->table` WHERE `vente` = 1 AND `vendeur` != :idUtilisateur AND (`titre` LIKE :mot_cle OR `description` LIKE :mot_cle) AND `prix_mini` BETWEEN :prix_mini AND :prix_max";
        if (!empty($tab["date"])) {
            $sql .= " AND `date_annonce` > :date";
            $param[":date"] = $tab["date"];
        }
        $sql .= " ORDER BY `date_annonce` DESC";
        $param[":mot_cle"] = $search;
        $param[":prix_mini"] = $prixMin;
        $param[":prix_max"] = $prixMax;
        $param[":idUtilisateur"] = $_SESSION["id"];
    }


    
}