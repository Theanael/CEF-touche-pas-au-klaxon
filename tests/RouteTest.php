<?php 
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../core/autoloader.php';
require __DIR__ . '/../core/env_loader.php';
require __DIR__ . '/../core/autoloader.php';

final class RouteTest extends TestCase{

    public function testCreateRoute(){
        $db = Database::getDb();
        $db->beginTransaction();
        try{
            // Preparing Data

            // Start Agency
            $startAgency = new Agency($db);
            $startAgency->setName('Agence départ');
            $startAgency->create();
            $id_start=$startAgency->getId();
            
            // Start Datetime
            
            $start_time=date('Y-m-d H:i:s',strtotime('+1 days +3 hours'));

            // End Agency
            $endAgency = new Agency($db);
            $endAgency->setName('Agence arrivée');
            $endAgency->create();
            $id_end=$endAgency->getId();
            
            // End Datetime
            $end_time=date('Y-m-d H:i:s',strtotime('+1 days +5 hours'));
    
            // Organizer
            $query=$db->prepare('INSERT INTO user(firstname,lastname,phone,email,password) VALUES (:firstname,:lastname,:phone,:email,:password)');
            $query->execute([
                'firstname'=>'John',
                'lastname'=>'Doe',
                'phone'=>'0102030405',
                'email'=>'j.doe@email.fr',
                'password'=>password_hash('password123*',PASSWORD_DEFAULT)
                ]);
            $user_id =$db->lastInsertId();
    
            // Places
            $seats = 5;
            $taken_seats = 0;

            // Creating Route
            $route = new Route($db);
            $route->setStartAgency($id_start);
            $route->setStartDatetime($start_time);
            $route->setEndAgency($id_end);
            $route->setEndDatetime($end_time);
            $route->setOrganizer($user_id);
            $route->setSeats($seats);
            $route->setTakenSeats($taken_seats);
            $route->create();
            // Verifying           
            $query = $db->prepare('SELECT * FROM route WHERE id = :id');
            $query->execute(['id' => $route->getId()]);

            $result = $query->fetch(PDO::FETCH_ASSOC);

            $this->assertNotFalse($result,'Route::create : can\'t find the new id in database.');

            $this->assertSame((int) $id_start,(int) $result['start_at'],'Route::create : the start agency wasn`t saved properly.'.print_r($startAgency->getList(),true));
            $this->assertSame(strtotime($start_time),strtotime($result['start_time']),'Route::create : the start time wasn`t saved properly.');
            $this->assertSame((int) $id_end, (int) $result['end_at'],'Route::create : the end agency wasn`t saved properly.'.print_r($result,true));
            $this->assertSame(strtotime($end_time),strtotime($result['end_time']),'Route::create : the end date wasn`t saved properly.');
            $this->assertSame((int) $user_id, (int)$result['organizer'],'Route::create : the organizer wasn`t saved properly.');
            $this->assertSame($seats,$result['seats'],'Route::create : the total seats wasn`t saved properly.');
            $this->assertSame(0,$result['taken_seats'],'Route::create : the taken seats wasn`t saved properly.');
            

        } finally {
            $db->rollBack();
        }
        

    }

    public function testEditRoute(){
        $db = Database::getDb();
        $db->beginTransaction();
            try {
            // Création de la route à éditer


            // Agence de Départ
            $startAgency = new Agency($db);
            $startAgency->setName('Agence départ');
            $startAgency->create();
            $id_start=$startAgency->getId();
            
            // Agence d'Arrivée
            $endAgency = new Agency($db);
            $endAgency->setName('Agence arrivée');
            $endAgency->create();
            $id_end=$endAgency->getId();
            
            // Auteur
            $query=$db->prepare('INSERT INTO user(firstname,lastname,phone,email,password) VALUES (:firstname,:lastname,:phone,:email,:password)');
            $query->execute([
                'firstname'=>'John',
                'lastname'=>'Doe',
                'phone'=>'0102030405',
                'email'=>'j.doe@email.fr',
                'password'=>password_hash('password123*',PASSWORD_DEFAULT)
                ]);
            $user_id =$db->lastInsertId();
    
            // Route
            $route = new Route($db);
            $route->setStartAgency($id_start);
            $route->setStartDatetime(date('Y-m-d H:i:s',strtotime('+1 days +3 hours')));
            $route->setEndAgency($id_end);
            $route->setEndDatetime(date('Y-m-d H:i:s',strtotime('+1 days +5 hours')));
            $route->setOrganizer($user_id);
            $route->setSeats(5);
            $route->setTakenSeats(0);
            $route->create();

            // Nouvelles Données

            // Agence de départ
            $newStartAgency = new Agency($db);
            $newStartAgency->setName('Nouvelle agence de départ');
            $newStartAgency->create();
            $new_id_start=$newStartAgency->getId();

            // Horaire de départ
            $new_date_start=date('Y-m-d H:i:s',strtotime('+1 days +2 hours'));

            // Agence d'arrivée
            $newEndAgency = new Agency($db);
            $newEndAgency->setName('Nouvelle agence d\'arrivée');
            $newEndAgency->create();
            $new_id_end=$newEndAgency->getId();

            // Horaire d'arrivée
            $new_end_time=date('Y-m-d H:i:s',strtotime('+1 days +6 hours'));

            // Auteur
            $query=$db->prepare('INSERT INTO user(firstname,lastname,phone,email,password) VALUES (:firstname,:lastname,:phone,:email,:password)');
            $query->execute([
                'firstname'=>'Jean',
                'lastname'=>'Dupont',
                'phone'=>'0102030406',
                'email'=>'j.dupont@email.fr',
                'password'=>password_hash('motdepasse456%',PASSWORD_DEFAULT)
                ]);
            $new_user_id =$db->lastInsertId();

            // Places 
            $new_total_seats = 4;
            $new_taken_seats = 3;

            // Modification du trajet
            $route_to_edit = new Route($db);
            $route_to_edit->findById($route->getId());
            $route_to_edit->setStartAgency($new_id_start);
            $route_to_edit->setStartDatetime($new_date_start);
            $route_to_edit->setEndAgency($new_id_end);
            $route_to_edit->setEndDatetime($new_end_time);
            $route_to_edit->setOrganizer($new_user_id);
            $route_to_edit->setSeats($new_total_seats);
            $route_to_edit->setTakenSeats($new_taken_seats);
            $route_to_edit->update();
            
            
            $query = $db->prepare('SELECT * FROM route WHERE id = :id');

            $query->execute(['id' => $route_to_edit->getId()]);

            $result = $query->fetch(PDO::FETCH_ASSOC);

            $this->assertNotFalse($result,'Route::create : edited route not found.');

            $this->assertSame((int) $new_id_start,(int) $result['start_at'],'Route::create : the start agency wasn`t saved properly.'.print_r($startAgency->getList(),true));
            $this->assertSame(strtotime($new_date_start),strtotime($result['start_time']),'Route::create : the start time wasn`t saved properly.');
            $this->assertSame((int) $new_id_end, (int) $result['end_at'],'Route::create : the end agency wasn`t saved properly.'.print_r($result,true));
            $this->assertSame(strtotime($new_end_time),strtotime($result['end_time']),'Route::create : the end date wasn`t saved properly.');
            $this->assertSame((int) $new_user_id, (int)$result['organizer'],'Route::create : the organizer wasn`t saved properly.');
            $this->assertSame($new_total_seats,$result['seats'],'Route::create : the total seats wasn`t saved properly.');
            $this->assertSame($new_taken_seats,$result['taken_seats'],'Route::create : the taken seats wasn`t saved properly.');
            



        } finally {
            $db->rollBack();
        }
    }

    public function testDeleteRoute(){
        $db = Database::getDb();
        $db->beginTransaction();
            


        try {
            // Création de la route à supprimer

            // Agence de Départ
            $startAgency = new Agency($db);
            $startAgency->setName('Agence départ');
            $startAgency->create();
            $id_start=$startAgency->getId();
            
            // Agence d'Arrivée
            $endAgency = new Agency($db);
            $endAgency->setName('Agence arrivée');
            $endAgency->create();
            $id_end=$endAgency->getId();
            
            // Auteur
            $query=$db->prepare('INSERT INTO user(firstname,lastname,phone,email,password) VALUES (:firstname,:lastname,:phone,:email,:password)');
            $query->execute([
                'firstname'=>'John',
                'lastname'=>'Doe',
                'phone'=>'0102030405',
                'email'=>'j.doe@email.fr',
                'password'=>password_hash('password123*',PASSWORD_DEFAULT)
                ]);
            $user_id =$db->lastInsertId();
    
            // Route
            $route = new Route($db);
            $route->setStartAgency($id_start);
            $route->setStartDatetime(date('Y-m-d H:i:s',strtotime('+1 days +3 hours')));
            $route->setEndAgency($id_end);
            $route->setEndDatetime(date('Y-m-d H:i:s',strtotime('+1 days +5 hours')));
            $route->setOrganizer($user_id);
            $route->setSeats(5);
            $route->setTakenSeats(0);
            $route->create();
            
            $id=$route->getId();
            $route_to_delete = new Route($db);
            $route_to_delete->findById($id);
            $route_to_delete->delete();

            $query = $db->prepare('SELECT * FROM route WHERE id = :id');
            $query->execute(['id' => $id]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $this->assertFalse($result,'Route::delete : the agency wasn\'t deleted properly.');

        } finally {
            $db->rollBack();
        }
        
    }

    
}