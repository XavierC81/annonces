<?php 

// Classe model pour héritage
/*
Fonctions publique :
    loadById($id) : Charge l'objet utilisateur d'id donné depuis la BDD
    set($champ, $valeur) : Mettre à jour la valeur d'attribut donné
    loadFromArray($tab) : Charge un objet à partir d'un tableau
    getAll() : Récupère la liste des objet de la classe
    id() : Retourne l'id
    insert() : Créer la ligne correspondant à l'objet dans la BDD
    update() : Mettre à jour la ligne correspondant à l'objet dans la BDD
    get($champ) : récupère la valeur du champ, l'objet cible pour les liens, un objet DateTime pour les dates. Par défaut 0 pour le nombre, "" pour les chaines, la date du jour pour les dates
    html($champ) : Retourner la valeur d'un champ en version html
    value($nomChamp) : retourne la valeur brute d'un champ
    listeExecuteRequest($sql, $param) : Exécute la requête et retourne la liste sous forme de tableau d'objets
*/
class _model {
    protected $champs = [];
    protected $table = "";
    protected $valeurs;
    protected $links = [];
    protected $champsNomComplet = [];
    protected $id = 0;



    // Méthodes magiques

    function __construct($id = null) {
        // Rôle : charger l'objet d'id donné si id
        // Retour : néant
        // Paramètre :
        //      $id : id donné
        if (isset($id)) {
            $this->loadById($id);
        }
    }


    function __get($champ) {
        // Rôle : Récupère la valeur de l'attribut correspondant
        // Retour : la valeur
        // Paramètres :
        //      $champ : nom du champ où récupérer la valeur
        if (array_key_exists($champ, $this->champs)) {
            return $this->html($champ);
        }
    }
    

    // Fonctions publiques


    public function nomComplet() {
        // Rôle : renvoie le nom complet (nom prenom) d'une personne
        // Retour : le nom complet
        // Paramètres : néant
        $nomComplet = [];
        foreach ($this->champsNomComplet as $champ) {
            $nomComplet[] = $this->valeurs[$champ];
        }
        return implode(" ", $nomComplet);
    }


    public function listExecuteRequest($sql, $param) {
        // Rôle : Exécute la requête et retourne la liste sous forme de tableau d'objets
        // Retour : un tableau d'objet
        // Paramètres :
        //      $sql : la requête SQL donnée
        //      $param : tableau de paramètres à injecter dans la requête

        $req = $this->executeRequest($sql, $param);
        if (! $this->verifierReq($req)) {
            return [];
        }
        $tab = [];
        while ($ligne = $req->fetch(PDO::FETCH_ASSOC)) {
            $tab[] = $ligne;
        }
        if (empty($tab)) {
            return [];
        }
        return $this->ArrayToObjArray($tab);
    }


    public function value($nomChamp) {
        // Rôle : retourne la valeur du champ
        // Retour : la valeur du champ
        // Paramètres :
        //      $nomChamp : nom du champ dont on veut retourner la valeur
        if (isset($this->valeurs[$nomChamp])) {
            return $this->valeurs[$nomChamp];
        }
    }


    public function get($nomChamp) {
        // Rôle : récupère la valeur du champ, l'objet cible pour les liens, un objet DateTime pour les dates. Par défaut 0 pour le nombre, "" pour les chaines, la date du jour pour les dates
        // Retour : élément du champ de nom indiqué
        // Paramètres :
        //      $nomChamp : nom du champ donné
        foreach ($this->champs as $champ=>$type) {
            if ($nomChamp == $champ){
                if ($type == "link") {
                    $result = $this->getLink($nomChamp);
                } else if ($type == "string") {
                    $result = $this->getString($nomChamp);
                } else if ($type == "number") {
                    $result = $this->getNumber($nomChamp);
                } else {
                    $result = $this->getDate($nomChamp);
                }
            }
        }
        return $result;
    }


    public function html($nomChamp) {
        // Rôle : Retourner la valeur d'un champ en version html
        // Retour : valeur à retourner
        // Paramètres :
        //      $nomChamp : nom du champ à retourner la valeur
        foreach ($this->champs as $nom => $type) {
            if ($nom == $nomChamp) {
                if ($type == "link") {
                    $html = $this->htmlLink($nomChamp);
                } else if ($type == "date") {
                    $html = $this->htmlDate($nomChamp);
                } else if ($type == "number") {
                    $html = $this->htmlNumber($nomChamp);
                } else {
                    $html = $this->htmlString($nomChamp);
                }
            }
        }
        return $html;
    }


    public function update() {
        // Rôle : Mettre à jour la ligne correspondant à l'objet dans la BDD
        // Retour : true si réussi, false sinon
        // Paramètres : néant
        $champs = $this->makeChampsUpdateInsert();
        $param = $this->makeParamArray();
        $param[":id"] = $this->id;
        $sql = "UPDATE `$this->table` SET $champs WHERE `id` = :id";

        $req = $this->executeRequest($sql, $param);
        if (!$this->verifierReq($req)) {
            return false;
        }
        return true;
    }



    public function insert() {
        // Rôle : Créer une ligne correspondant  à l'objet courant dans la BDD
        // Retour : True si réussi, false sinon
        // Paramètres : néant
        $champs = $this->makeChampsUpdateInsert();
        $param = $this->makeParamArray();
        $sql = "INSERT INTO `$this->table` SET $champs";
        $req = $this->executeRequest($sql, $param);

        if (!$this->verifierReq($req)) {
            return false;
        }
        global $bdd;
        $this->id = $bdd->lastInsertId();
        return true;
    }


    public function id() {
        // rôle : récupère l'id de l'objet courant
        // Retour : id de l'objet courant
        // Paramètres :
        if (empty($this->id)) {
            return 0;
        }
        return $this->id;
    }
    

    public function getAll() {
        // Rôle : récupère la liste complète d'objets de la classe
        // Retour : tableau d'objet de la classe
        // Paramètres : néant
        $champs = $this->makeChampsSelect();
        $sql = "SELECT `id`, $champs FROM `$this->table`";
        $req = $this->executeRequest($sql);
        if (!$this->verifierReq($req)) {
            return [];
        }
        $tab = [];
        while($ligne = $req->fetch(PDO::FETCH_ASSOC)) {
            $tab[] = $ligne;
        }
        if (empty($tab)) {
            return [];
        }    
        return $this->ArrayToObjArray($tab);
    }


    public function loadById($id) {
        // Rôle : Charge l'objet utilisateur d'id donné depuis la BDD
        // Retour true si réussi, false sinon
        // Paramètres :
        //      $id : id donné
        $champs = $this->makeChampsSelect();
        $sql = "SELECT `id`, $champs FROM `$this->table` WHERE `id` = :id";
        $req = $this->executeRequest($sql, [":id"=>$id]);
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

    public function set($champ, $valeur) {
        // Rôle : Mettre à jour ou charger l'attribut valeur correspondant
        // Retour true ou false
        // Paramètres :
        //      $champ : nom du champ où charger la valeur
        //      $valeur : nouvelle valeur à charger
        if (! isset($this->champs[$champ])) {
            return false;
        }
        $this->valeurs[$champ] = $valeur;
        return true;
    }

    public function loadFromArray($tab) {
        // Rôle : charge l'objet courant avec les valeurs de $tab
        // Retour : néant
        // Paramètres :
        //      $tab : tableau contenant les nouvelles valeurs à charger dans l'objet
        foreach ($this->champs as $champ => $type) {
            if (isset($tab[$champ])) {
                $this->set($champ, $tab[$champ]);
            }
        }
    }




    // Fonctions protégé



    protected function htmlDate($nomChamp) {
        // Rôle : Retourne la valeur html du nom du champ
        // Retour : la valeur du champ (date), date du jour si non existant
        // Paramètres :
        //      $nomChamp : nom du champ à retourner la valeur
        if (empty($this->valeurs[$nomChamp])) {
            $obj = new DateTime();
            $html = htmlentities($obj->format("d/m/Y"));
        } else {
            $obj = new DateTime($this->valeurs[$nomChamp]);
            $html = htmlentities($obj->format("d/m/Y"));
        }
        return $html;
    }


    protected function htmlNumber($nomChamp) {
        // Rôle : Retourne la valeur html du nom du champ
        // Retour : la valeur du champ (number), 0 si non existant
        // Paramètres :
        //      $nomChamp : nom du champ à retourner la valeur
        if (empty($this->valeurs[$nomChamp])) {
            $html = 0;
        } else {
            $html = htmlentities($this->valeurs[$nomChamp]);
        }
        return $html;
    }


    protected function htmlString($nomChamp) {
        // Rôle : Retourne la valeur html du nom du champ
        // Retour : la valeur du champ (string), vide si non existant
        // Paramètres :
        //      $nomChamp : nom du champ à retourner la valeur
        if (empty($this->valeurs[$nomChamp])) {
            $html = "";
        } else {
            $html =nl2br(htmlentities($this->valeurs[$nomChamp]));
        }
        return $html;
    }


    protected function htmlLink($nomChamp) {
        // Rôle : Retourne la valeur html du nom du lien
        // Retour : le nom complet du lien
        // Paramètres :
        //      $nomChamp : nom du champ à retourner la valeur
        if (empty($this->valeurs[$nomChamp])) {
            $html = "";
        } else {
            $target = $this->links["$nomChamp"];
            $obj = new $target();
            $obj->loadById($this->valeurs[$nomChamp]);
            $html = htmlentities($obj->nomComplet());
        }
        return $html;
    }


    private function getDate($nomChamp) {
        // Rôle : retourne la valeur d'un attribut 
        // Retour : objet date, date du jour si non existant
        // Paramètre :
        //      $nomChamp : nom du champ à retourner la valeur
        if (empty($this->valeurs[$nomChamp])) {
            $obj = new DateTime();
        } else {
            $obj = new DateTime();
            $obj = $this->valeurs[$nomChamp];
        }
        return $obj;
    }


    protected function getNumber($nomChamp) {
        // Rôle : retourne la valeur d'un attribut
        // Retour : valeur de l'attribut (number), valeur à 0 si non existant
        // Paramètre :
        //      $nomChamp : nom du champ à retourner la valeur
        if (empty($this->valeurs[$nomChamp])) {
            $obj = 0;
        } else {
            $obj = $this->valeurs[$nomChamp];
        }
        return $obj;
    }


    protected function getString($nomChamp) {
            // Rôle : retourne la valeur d'un attribut
            // Retour : valeur de l'attribut (string), valeur vide si non existant
            // Paramètre :
            //      $nomChamp : nom du champ à retourner la valeur
            if (empty($this->valeurs[$nomChamp])) {
                $obj = "";
            } else {
                $obj = $this->valeurs[$nomChamp];
            }
            return $obj;
        
    }

    protected function getLink($nomChamp) {
        // Rôle : Verifie si un objet est déjà chargé, si non le charge
        // Retour : l'objet donné ou un objet vide si inexistant
        // Paramètre :
        //      $nomChamp : nom du champ qui est un lien
        if (empty($this->valeurs[$nomChamp])) {
            $target = $this->links["$nomChamp"];
            $obj = new $target();
        } else {
                $target = $this->links[$nomChamp];
                $obj = new $target($this->valeurs[$nomChamp]);
                }
        
        return $obj; 
    }



    protected function ArrayToObjArray($tab) {
        // Rôle : Transforme un tableau de tableaux en tableau d'objets
        // Retour : tableau d'objet
        // Paramètres :
        //      $tab : tableau de tableaux
        $objArray = [];
        $classe = get_class($this);
        foreach ($tab as $obj) {
            $object = new $classe();
            $object->loadFromArray($obj);
            $object->id = $obj["id"];
            $objArray[$obj["id"]] = $object;
        }
        return $objArray;
    }


    protected function makeParamArray() {
        // Rôle : fabrique le tableau des paramètres à injecter dans une requête SQL
        // Retour : tableau de paramètre SQL
        // Paramètres : néant
        $tab = [];
        foreach ($this->champs as $champ => $type) {
            if (isset( $this->valeurs[$champ])) {
                $tab[":$champ"] = $this->valeurs[$champ];
            } else {
                $tab[":$champ"] = null;
            }
        }
        return $tab;
    }


    protected function makeChampsUpdateInsert() {
        // Rôle : Fabrique un string des champs lisible pour un UPDATE ou un INSERT en SQL
        // Retour : string construit
        // Paramètres : néant
        $tab = [];
        foreach ($this->champs as $champ => $type) {
            $tab[] = "`$champ` = :$champ";
        }
        return implode(", ", $tab);
    }


    protected function makeChampsSelect() {
        // Rôle : Fabrique un string des champs lisible pour un SELECT en SQL
        // Retour : string construit
        // Paramètres : néant
        $tab = [];
        foreach ($this->champs as $champ => $type) {
            $tab[] = "`$champ`";
        }
        return implode(", ", $tab);
    }

    protected function executeRequest($sql, $param = []) {
        // Rôle : Exécute une requête à la BDD
        // Retour : la requête, false si echoué
        // Paramètres :
        //      $sql : la requête SQL à exécuter 
        //      $param : le tableau des paramètres à injecter à l'exécution de la requête
        global $bdd;
        $req = $bdd->prepare($sql);
        if (!$req->execute($param)) {
            echo "Echec de la requête $sql avec les paramètres : ";
            print_r($param);
            return false;
        }
        return $req;
    }

    protected function verifierReq($req) {
        // Rôle : Vérifier si la requête à renvoyer false
        // Retour : true ou false
        // Paramètres : 
        //      $req : requête donnée
        if ($req == false) {
            $this->id = 0;
            return false;
        } else {
            return true;
        }
    }
}