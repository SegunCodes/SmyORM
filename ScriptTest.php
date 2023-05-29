<?php

require_once __DIR__ . '/vendor/autoload.php';
use SmyORM\SmyORM\Orm;

class ScriptTest{
    private $orm;

    public function __construct() {
        $this->setUp();
    }

    public function setUp(): void {
        $db = new \PDO('mysql:host=localhost;dbname=testormdb', 'root', '');

        // Create a concrete class that extends the ORM class
        $this->orm = new class($db) extends Orm {
            public function tableName(): string {
                return 'users';
            }

            public function attributes(): array {
                return ['name', 'email', 'role'];
            }
        };
    }
    

    public function testSave() {
        // Create a sample object with data
        $data = [
            'name' => 'Joe',
            'email' => 'john@doe.com',
            'role' => 'User'
        ];
        foreach ($data as $attribute => $value) {
            $this->orm->{$attribute} = $value;
        }

        // Call the save() method
        $result = $this->orm->save();
        return $result;
    }

    public function testFindOne() {
        // Call the findOne() method
        $result = $this->orm->findOne([
            "id" => 16
        ]);
    
        return $result;
    }

    public function testfindOneOrWhere() {
        // Call the findOneOrWhere() method
        $result = $this->orm->findOneOrWhere([
            "id" => 16
        ], [
            "role" => "Admin"
        ]);
    
        return $result;
    }

    public function testFindAll() {
        // Call the findAll() method
        $result = $this->orm->findAll();
    
        return $result;
    }

    public function testfindAllWhere() {
        // Call the findAllWhere() method
        $result = $this->orm->findAllWhere([
            "id" => 1
        ]);
    
        return $result;
    }

    public function testfindAllOrWhere() {
        // Call the findAllOrWhere() method
        $result = $this->orm->findAllOrWhere([
            "id" => 13
        ], [
            "name" => "joe"
        ]);
    
        return $result;
    }

    public function testCount() {
        // Call the count() method
        $result = $this->orm->count();
    
        return $result;
    }
    
    public function testcountWhere() {
        // Call the countWhere() method
        $result = $this->orm->countWhere([
            "id" => 1
        ]);
    
        return $result;
    }

    public function testcountOrWhere() {
        // Call the countOrWhere() method
        $result = $this->orm->countOrWhere([
            "id" => 13
        ], [
            "id" => 15
        ]);
    
        return $result;
    }

    public function testdelete() {
        // Call the delete() method
        $result = $this->orm->delete([
            "id" => 1
        ]);
    
        return $result;
    }

    public function testdeleteOrWhere() {
        // Call the countOrWhere() method
        $result = $this->orm->deleteOrWhere([
            "id" => 13
        ], [
            "id" => 15
        ]);
    
        return $result;
    }

    public function testUpdate() {
        // Call the update() method
        $result = $this->orm->update([
            "name" => "john Doe"
        ], [
            "id" => 13
        ]);
    
        return $result;
    }

    public function testupdateOrWhere() {
        // Call the updateOrWhere() method
        $result = $this->orm->updateOrWhere([
            "name" => "Joe doe"
        ], [
            "id" => 17,
            "role" => "User"
        ], [
            "id" => 13,
            "role" => "Admin"
        ]);
    
        return $result;
    }

    

}

