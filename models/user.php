<?php
class User{

    // Connexion à la db.
    protected PDO $db;
    
    // Identifiant de l'utilisateur
    protected $id;

    // Prénom de l'utilisateur
    protected $firstname = "";

    // Nom de l'utilisateur
    protected $lastname = "";

    // Téléphone de l'utilisateur.
    protected $phone = "";

    // E-Mail de l'utilisateur, sert aussi d'identifiant de connexion.
    protected $email = "";

    // Indique si l'utilisateur est administrateur.
    public $admin = false;
    
    public function __construct($db) {
        $this->db=$db;
    }

    /**
     * getId
     *retourne 
     * @return Number l'id de l'utilisateur
     */
    public function getId(){
        return $this->id;
    }
    
    /**
     * getFullname
     * retourne le nom complet de l'utilisateur au format "Prénom Nom"
     * @return String le nom complet de l'utilisateur
     */
    public function getFullname(){
        return $this->firstname.' '.$this->lastname;
    }

    /**
     * getFirstname
     * retourne le prénom de l'utilisateur
     * @return String le prénom de l'utilisateur
     */
    public function getFirstname(){
        return $this->firstname;
    }

    /**
     * getLastname
     * retourne le nom de famille de l'utilisateur
     * @return String le nom de famille de l'utilisateur
     */
    public function getLastname(){
        return $this->lastname;
    }

    /**
     * getPhone
     * retourne le téléphone de l'utilisateur non formaté
     * @return String le téléphone de l'utilisateur
     */
    public function getPhone(){
        return $this->phone;
    }

    /**
     * getMail
     * Retourne l'email de l'utilisateur.
     * @return String l'email de l'utilisateur.
     */
    public function getMail(){
        return $this->email;
    }

    /**
     * isAdmin
     * indique si l'utilisateur est administrateur.
     * @return Bool true si l'utilisateur est administrateur, false sinon.
     */
    public function isAdmin(){
        return $this->admin;
    }

    /**
     * getList
     * Retourne un tableau contenant tous les utilisateurs.
     * @return Array un tableau contenant tous les utilisateurs.
     */
    public function getList(){
        $query = $this->db->query(
            'SELECT id, firstname, lastname, phone, email,admin
            FROM user'
        );
        $list=[];
        while($row=$query->fetch(PDO::FETCH_ASSOC)){
            $user=new User($this->db);
            $user->hydrate($row);
            $list[]=$user;
        }
        return $list;
    }

    /**
     * findById
     * Charge un utilisateur à partir de son identifiant.
     * @param mixed $id l'identifiant de l'utilisateur
     * @return Bool true si la requête a fonctionné, false sinon.
     */
    public function findById($id){
        $query = $this->db->prepare(
            'SELECT id, firstname, lastname, phone, email, password,admin
            FROM user
            WHERE id = :id'
        );

        $query->execute(['id'=>$id]);

        $data = $query->fetch(PDO::FETCH_ASSOC);

        if(!$data){
            return false;
        }else{
            $this->hydrate($data);
            return true;
        }
    }

    /**
     * authenticate
     * authentifie un utilisateur et récupère ses informations.
     * @param mixed $email l'email de l'utilisateur.
     * @param mixed $password le mot de passe de l'utilisateur.
     * @return Bool true si l'authentification a réussi, false sinon.
     */
    public function authenticate($email, $password){
        $query = $this->db->prepare(
            'SELECT id, firstname, lastname, phone, email, password,admin
            FROM user
            WHERE email = :email'
        );

        $query->execute(['email' => $email]);

        $data = $query->fetch(PDO::FETCH_ASSOC);

        if (!$data || !password_verify($password, $data['password'])) {
            return false;
        }

        $this->hydrate($data);
        return true;
    }


    /**
     * hydrate
     * remplit les attributs de l'utilisateur à partir d'un tableau.
     * @param Array $data le tableau source.
     * @return void
     */
    protected function hydrate($data){
        
            $this->id = $data['id'];
            $this->firstname = $data['firstname'];
            $this->lastname = $data['lastname'];
            $this->phone = $data['phone'];
            $this->email = $data['email'];
            $this->admin = $data['admin'];
    }



}