<?php
class Agency{
    

    protected PDO $db;


    protected $id;
    protected $name = "";


    /**
     * __construct
     * initialise une instance d'Agency.
     * @param PDO $db connexion à la base de donnée.
     * @return void
     */

    public function __construct(PDO $db) {
        $this->db=$db;
    }

    /**
     * getId
     * retourne l'identifiant de l'agence.
     * @return Number identifiant de l'agence.
     */
    public function getId(){
        return $this->id;
    }

    /**
     * setName
     * modifie le nom de l'agence.
     * @param String $name le nouveau nom de l'agence.
     * @return void
     */
    public function setName($name){
        // trim le nom et vérifier qu'il est d'une taille acceptée.
        $this->name = $name;
    }

    /**
     * getName
     * retourne le nom de l'agence.
     * @return String le nom de l'agence.
     */
    public function getName(){
        return $this->name;
    }

    /**
     * findById
     * récupère une agence en fonction de son identifiant.
     * @param mixed $id l'identifiant recherché.
     * @return void
     */
    public function findById($id){
        $query = $this->db->prepare(
            'SELECT id, name 
            FROM agency 
            WHERE id = :id'
        );

        $query->execute(['id' => $id]);

        $data = $query->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $this->id = $data['id'];
            $this->name = $data['name'];
            return true;
        }

        return false;
    }

    /**
     * getList
     * retourne la liste des agences 
     * @return Array un array d'Agency contenant la liste.
     */
    public function getList(){
        $query = $this->db->query(
            'SELECT id, name FROM agency ORDER BY name ASC'
        );
        $list=[];
        while($row = $query->fetch()){
            $agency = new Agency($this->db);
            $agency->id=$row['id'];
            $agency->name=$row['name'];
            $list[]=$agency;
        }
        return $list;

    }

    /**
     * create
     * ajoute en base de donnée l'agence et récupère le nouvel identifiant.
     * @return Bool true si la requête a réussi false sinon.
     */
    public function create(){
        $query = $this->db->prepare(
            'INSERT INTO agency (name) VALUES (:name)'
        );

        $result = $query->execute([
            'name' => $this->name
        ]);

        if ($result) {
            $this->id = $this->db->lastInsertId();
        }

        return $result;
    }

    /**
     * delete
     * supprime l'agence en base de donnée.
     * @return Bool true si la requête a réussi false sinon.
     */
    public function delete(){
        $query = $this->db->query('DELETE FROM agency WHERE id="'.$this->id.'" ');
        return $query;    
    }

    /**
     * update
     * applique les changements fait à l'agence en base de donnée.
     * @return void
     */
    public function update(){
        $query = $this->db->prepare('UPDATE agency
        SET name=:name 
        WHERE id=:id ');
        $result = $query->execute([
            'name' => $this->name,
            'id' => $this->id
        ]);
        return $query;    
    }


}