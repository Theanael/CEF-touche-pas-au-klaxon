<?php
class User{
    protected PDO $db;

    protected $id;
    protected $firstname = "";
    protected $lastname = "";
    protected $phone = "";
    protected $email = "";
    public $admin = false;
    
    public function __construct($db) {
        $this->db=$db;
    }

    public function getFullname(){
        return $this->firstname.' '.$this->lastname;
    }
    
    public function getFirstname(){
        return $this->firstname;
    }

    public function getLastname(){
        return $this->lastname;
    }

    public function getPhone(){
        return $this->phone;
    }

    public function getMail(){
        return $this->email;
        
    }

    public function isAdmin(){
        return $this->admin;
    }

    public function findById($id){
        $query = $this->db->prepare(
            'SELECT id, firstname, lastname, phone, email, password
            FROM user
            WHERE id = :id'
        );

        $query->execute(['id'=>$id]);

        $data = $query->fetch(PDO::FETCH_ASSOC);

        if(!$data){
            return false;
        }else{
            
            $this->id = $data['id'];
            $this->firstname = $data['firstname'];
            $this->lastname = $data['lastname'];
            $this->phone = $data['phone'];
            $this->email = $data['email'];
            return true;
        }
    }


    public function authenticate($email, $password){
        $query = $this->db->prepare(
            'SELECT id, firstname, lastname, phone, email, password
            FROM user
            WHERE email = :email'
        );

        $query->execute(['email' => $email]);

        $data = $query->fetch(PDO::FETCH_ASSOC);

        if (!$data || !password_verify($password, $data['password'])) {
            return false;
        }

        $this->id = $data['id'];
        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];
        $this->phone = $data['phone'];
        $this->email = $data['email'];

        return true;
    }




}