<?php

use Buki\Router\Http\Controller;

class BaseController extends Controller{


    // PDO utilisé pour toutes les requêtes SQL.
    protected PDO $db;
    
    // Utilisateur connecté
    protected ?User $currentUser;

    

    /**
     * getUserAndDb
     * récupère la connexion à la base de donnée et récupère l'utilisateur connecté s'il y en a un.
     * @return void
     */
    
    protected function getUserAndDb(){
        $this->db=Database::getDb();
        if (!empty($_SESSION['user'])){
            $this->currentUser=new User($this->db);
            $this->currentUser->findById($_SESSION['user']);
        }
    }
}