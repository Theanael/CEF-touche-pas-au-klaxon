<?php 
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../core/autoloader.php';
require __DIR__ . '/../core/env_loader.php';
require __DIR__ . '/../core/autoloader.php';

final class CoreTest extends TestCase{

    public function testDb(){
        
        $db = Database::getDb();
        $db->beginTransaction();

        try {
            $query = $db->query('select 1 as test;');
            $result = $query->fetch();
            $this->assertNotFalse($result,'can\'t connect to Database.');
            $this->assertSame((int) $result['test'],1,'can\'t connect to Database.');
        } finally {
            $db->rollBack();
        }
    }

    
}