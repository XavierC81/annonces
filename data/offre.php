<?php 

// Classe offre : manipuler l'objet offre

class offre extends _model {
    protected $champs = ["annonce"=>"link", "acheteur"=>"link", "prix"=>"number", "statut"=>"number", "vue_vendeur"=>"number", "vue_acheteur"=>"number", "date_offre"=>"date"];
    protected $table = "offre";
    protected $links = ["annonce"=>"annonce", "acheteur"=>"utilisateur"];

    // Fonctions publiques

    public function getOffres($idAnnonce) {
        // Rôle : Récupère toutes les offres liées à l'annonce courante
        // Retour : tableau d'objets de la classe offre
        // Paramètres : 
        //      $idAnnonce : id de l'annonce donné

        $champs = $this->makeChampsSelect();
        $sql = "SELECT `id`, $champs FROM `$this->table` WHERE `annonce` = :annonce AND `statut` = 1 ORDER BY `prix` DESC";
        return $this->listExecuteRequest($sql, [":annonce"=>$idAnnonce]);

    }
    public function getOffresTermine($idAnnonce) {
        // Rôle : Récupère toutes les offres liées à l'annonce courante
        // Retour : tableau d'objets de la classe offre
        // Paramètres : 
        //      $idAnnonce : id de l'annonce donné

        $champs = $this->makeChampsSelect();
        $sql = "SELECT `id`, $champs FROM `$this->table` WHERE `annonce` = :annonce AND `statut` = 2 ORDER BY `prix` DESC";
        return $this->listExecuteRequest($sql, [":annonce"=>$idAnnonce]);

    }


    public function getOffreSelfAnnonces($idUtilisateur) {
        // Rôle : récupère la liste des annonces de l'utilisateur connecté
        // Retour : tableau des offres correspondant aux annonces de l'utilisateur connecté
        // Paramètres : 
        //      $idUtilisateur = id de l'utilisateur connecté
        $sql = "SELECT `offre`.`id` AS 'idOffre', `annonce`.`id` AS 'idAnnonce', `offre`.`prix` AS 'prix', `offre`.`statut` AS 'statut', `offre`.`vue_vendeur` AS 'vue_vendeur', `offre`.`vue_acheteur` AS 'vue_acheteur', `annonce`.`titre` AS 'titre'
        FROM `offre`
        LEFT JOIN `annonce` ON `offre`.`annonce` = `annonce`.`id`
        LEFT JOIN `utilisateur` ON `utilisateur`.`id` = `annonce`.`vendeur`
        WHERE `annonce`.`vendeur` = :idUtilisateur AND `offre`.`vue_vendeur` = 1";
        $req = $this->executeRequest($sql, [":idUtilisateur"=>$idUtilisateur]);
        if (!$this->verifierReq($req)) {
            return [];
        }
        $tab = $req->fetchAll(PDO::FETCH_ASSOC);
        if (empty($tab)) {
            return [];
        }
        return $tab;
    }


    public function creerOffre($post, $idUtilisateur) {
        // Rôle : Créer une offre dans la BDD
        // Retour : true ou false
        // Paramètres : 
        //      $post : tableau contenant les valeur de prix et annonce
        //      $idUtilisateur : id de l'utilisateur connecter
        if ($this->get("annonce")->statut == 2) {
            return false;
        }
        $this->loadFromArray($post);
        $this->set("acheteur", $idUtilisateur);
        $date = date("Y-m-d H:i:s");
        $this->set("date_offre", $date);
        $this->set("vue_vendeur", 1);
        $this->set("vue_acheteur", 1);
        $this->set("statut", 1);
        if(!$this->insert()) {
            return false;
        }
        return true;
    }

    public function changeStatut($action) {
        // Rôle : Change le statut de l'offre courante, si accepter change le statut des autres offres de la même annonce
        // Retour : néant
        // Paramètres :
        //      $action : accepter ou refuser
        if ($action == "refuser") {
            $this->set("statut", 3);
            $this->set("vue_acheteur", 1);
            $this->set("vue_vendeur", 1);
            $this->update();
        } else {
            $offres = $this->getOffres($this->get("annonce")->id());
            foreach ($offres as $detailOffre) {
                $detailOffre->set("statut", 3);
                $this->set("vue_acheteur", 1);
                $this->set("vue_vendeur", 1);
                $detailOffre->update();
            }
            $this->set("statut", 2);
            $this->update();
            $this->get("acheteur")->genererMailAccepter($this);
            $annonce = $this->get("annonce");
            $annonce->set("vente",2);
            $this->set("vue_acheteur", 1);
            $this->set("vue_vendeur", 1);
            $annonce->update();
        }
    }

    public function nombreOffre($offres, $statut) {
        // Rôle : Vérifie si une offre existe dans un statut donné
        // Retour : true ou false
        // Paramètres : 
        //      $offres : tableau d'objets offre
        //      $vente : le statut de l'offre
        $tab = [];
        foreach ($offres as $offre) {
            if ($offre->get("statut") == $statut) {
                $tab[] = $offre;
            }
        }
        if (count($tab) == 0) {
            return false;
        }
        return true;
    }



    public function getSelfOffres($idAcheteur) {
        // Rôle : récupère la liste des offres de l'utilisateur connecté
        // Retour : tableau d'objets offres
        // Paramètres : néant 
        $champs = $this->makeChampsSelect();
        $sql = "SELECT `id`, $champs FROM `$this->table` WHERE `acheteur` = :acheteur  ORDER BY `date_offre` DESC";
        return $this->listExecuteRequest($sql, [":acheteur"=>$idAcheteur]);
    }


    public function getSelfOffresVue($idAcheteur) {
        // Rôle : récupère la liste des offres de l'utilisateur connecté
        // Retour : tableau d'objets offres
        // Paramètres : néant 
        $champs = $this->makeChampsSelect();
        $sql = "SELECT `id`, $champs FROM `$this->table` WHERE `acheteur` = :acheteur AND `vue_acheteur` = 1 ORDER BY `date_offre` DESC";
        return $this->listExecuteRequest($sql, [":acheteur"=>$idAcheteur]);
    }
}