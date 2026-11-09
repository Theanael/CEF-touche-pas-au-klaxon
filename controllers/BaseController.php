<?php

use Buki\Router\Http\Controller;

class BaseController extends Controller{
    protected PDO $db;
    protected ?User $currentUser;


    protected function getUserAndDb(){
        $this->db=Database::getDb();
        if (!empty($_SESSION['user'])){
            $this->currentUser=new User($this->db);
            $this->currentUser->findById($_SESSION['user']);
        }
    }
}