<?php
class Agency{
    protected PDO $db;

    protected $id;
    protected $name = "";

    public function __construct($db) {
        $this->db=$db;
    }

    public function setName($name){
        // trim le nom et vérifier qu'il est d'une taille acceptée.
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

    public function findById($id){
        $query = $this->db->prepare(
            'SELECT id, name FROM agency WHERE id = :id'
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

    public function delete(){
        $query = $this->db->query('DELETE FROM agency WHERE id="'.$this->id.'" ');
        return $query;    
    }


}