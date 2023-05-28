<?php

use PHPUnit\Framework\TestCase;
use SmyORM\SmyORM\Orm;

class OrmTest extends TestCase {
    private $orm;

    protected function setUp(): void {
        parent::setUp();

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
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'role' => 'Admin'
        ];
        foreach ($data as $attribute => $value) {
            $this->orm->{$attribute} = $value;
        }

        // Call the save() method
        $result = $this->orm->save();

        // Assert
        $this->assertTrue($result);
    }

    public function testFindOne() {
        // Call the findOne() method
        $result = $this->orm->findOne([
            "id" => 1
        ]);

        // Assert
        $this->assertTrue($result);
    }

    public function testfindOneOrWhere() {
        // Call the findOneOrWhere() method
        $result = $this->orm->findOneOrWhere([
            "id" => 1
        ], [
            "email" => "kaaka"
        ]);

        // Assert
        $this->assertTrue($result);
    }
}

