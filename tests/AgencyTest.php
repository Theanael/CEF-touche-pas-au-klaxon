<?php 
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../core/autoloader.php';
require __DIR__ . '/../core/env_loader.php';
require __DIR__ . '/../core/autoloader.php';

final class AgencyTest extends TestCase{

    // teste la création d'agence et l'enregistrement dans la base de donnée.
    public function testCreateAgency()
    {
        $db = Database::getDb();
        $db->beginTransaction();

        try {
            $name = "Agence de Test";

            $agency = new Agency($db);
            $agency->setName($name);

            $this->assertSame($name, $agency->getName(),"Agency::setName/getName");

            $agency->create();

            $query = $db->prepare('SELECT * FROM agency WHERE id = :id');
            $query->execute(['id' => $agency->getId()]);

            $result = $query->fetch(PDO::FETCH_ASSOC);

            $this->assertNotFalse($result,'Agency::create : can\'t find the id in database.');
            $this->assertSame($name,$result['name'],'Agency::create : the name wasn`t saved properly.');
        } finally {
            $db->rollBack();
        }
    }
    
    // teste la modification d'agence et l'enregistrement dans la base de donnée.
    public function testEdit(){    
        $db = Database::getDb();
        $db->beginTransaction();

        try {
            $name = "Agence de Test";

            $agency = new Agency($db);
            $agency->setName($name);
            $agency->create();

            $agency_to_edit = new Agency($db);
            $agency_to_edit->findById($agency->getId());
        
            $this->assertSame($agency->getName(),$agency_to_edit->getName(),"Agency::findById");

            $new_name="Agence de Test 2";
            $agency->setName($new_name);

            $agency->update();

            $query = $db->prepare('SELECT * FROM agency WHERE id = :id');
            $query->execute(['id' => $agency->getId()]);

            $result = $query->fetch(PDO::FETCH_ASSOC);
            $this->assertNotFalse($result,'Agency::update : the Agency can\'t be found');
            $this->assertSame($new_name,$result['name'],'Agency::update : the name wasn\'t properly updated');
        } finally {
            $db->rollBack();
        }
    }

    // teste la suppression d'agence dans la base de donnée.
    public function testDelete(){    
        $db = Database::getDb();
        $db->beginTransaction();
        try{
            $name = "Agence de Test";

            $agency = new Agency($db);
            $agency->setName($name);
            $agency->create();

            $id = $agency->getId();

            $agency_to_delete = new Agency($db);
            $agency_to_delete->findById($id);

            $agency_to_delete->delete();

            $query = $db->prepare('SELECT * FROM agency WHERE id = :id');
            $query->execute(['id' => $id]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $this->assertFalse($result,'Agency::delete : the agency wasn\'t deleted properly.');
        }finally{
            $db->rollBack();
        }
        
    }
}