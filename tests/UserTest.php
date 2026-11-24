<?php 
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../core/autoloader.php';
require __DIR__ . '/../core/env_loader.php';
require __DIR__ . '/../core/autoloader.php';

final class UserTest extends TestCase{

    public function testAuthentification(){
        
        $db = Database::getDb();
        $db->beginTransaction();
        try {

        $firstname = "John";
        $lastname = "Doe";
        $phone="0102030405";
        $email = "j.doe@email.fr";
        $password = "password123*";
        $admin = 0;

        //créer un utilisateur
        $query=$db->prepare('INSERT INTO user(firstname,lastname,phone,email,password) VALUES (:firstname,:lastname,:phone,:email,:password)');
        $query->execute([
            'firstname'=>$firstname,
            'lastname'=>$lastname,
            'phone'=>$phone,
            'email'=>$email,
            'password'=>password_hash($password,PASSWORD_DEFAULT)
            ]);
        $id =$db->lastInsertId();

        //tester la connexion
        $user = new User($db);

        $auth = $user->authenticate($email,$password);
        
        $this->assertNotFalse($auth);
        $this->assertSame((int) $id,$user->getId(),print_r($id,true));

        // tester une connexion ratée
        $user = new User($db);
        $auth = $user->authenticate($email,"wrong_password");
        $this->assertFalse($auth);

        } finally {
            $db->rollBack();
        }
    }


    
}