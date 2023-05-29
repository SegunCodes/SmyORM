# SMYORM

- [Description](#description)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
    1. [Instantiating the ORM](#instantiate-orm)
    2. [Query Builders](#query-builders)
- [Contributing and Vulnerabilities](#contributing-and-vulnerabilities)
- [License](#license)

# DESCRIPTION

SmyORM is a PHP Object-relational mapping (ORM) that allows developers to write code in simple programming languages of their choice instead of using SQL to access, add, update, and delete data and schemas in the respective database. It is currently being used by the SmyPhp framework

# REQUIREMENTS

- php 7.3^
- composer

# INSTALLATION

```shell
$ composer require seguncodes/smyorm 
```
# USAGE

### Instantiating the ORM

Create a Model for each database table eg User.php or Transaction.php; Or a basic file to handle the SQL operations for a specific table. Then instantiate the ORM this way:

`User.php` file
```php
require_once __DIR__ . '/vendor/autoload.php';
use SmyORM\SmyORM\Orm;

class User{
    private $orm;

    public function __construct() {
        $this->setUp();
    }

    public function setUp(): void {
        $db = new \PDO('mysql:host=localhost;dbname=yourDatabaseName', 'username', 'password');

        // Create a concrete class that extends the ORM class
        $this->orm = new class($db) extends Orm {
            public function tableName(): string {
                return 'users'; // the name of the table that this model references
            }

            public function attributes(): array {
                return ['name', 'email', 'role']; // attributes of the table
            }
        };
    }
}
```


### Query Builders
The ORM comes with various query builders 
`save()`
The save method saves data into database 

`User.php` file
```php
require_once __DIR__ . '/vendor/autoload.php';
use SmyORM\SmyORM\Orm;

class User{
    private $orm;

    public function __construct() {
        $this->setUp();
    }

    public function setUp(): void {
        $db = new \PDO('mysql:host=localhost;dbname=yourDatabaseName', 'username', 'password');

        // Create a concrete class that extends the ORM class
        $this->orm = new class($db) extends Orm {
            public function tableName(): string {
                return 'users'; // the name of the table that this model references
            }

            public function attributes(): array {
                return ['name', 'email', 'role']; // attributes of the table
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
}
```

`findOne()` 
finds row WHERE argument exists and returns only 1
```php
require_once __DIR__ . '/vendor/autoload.php';
use SmyORM\SmyORM\Orm;

class User{
    private $orm;

    public function __construct() {
        $this->setUp();
    }

    public function setUp(): void {
        $db = new \PDO('mysql:host=localhost;dbname=yourDatabaseName', 'username', 'password');

        // Create a concrete class that extends the ORM class
        $this->orm = new class($db) extends Orm {
            public function tableName(): string {
                return 'users'; // the name of the table that this model references
            }

            public function attributes(): array {
                return ['name', 'email', 'role']; // attributes of the table
            }
        };
    }

    public function testFindOne() {
        // Call the findOne() method
        $result = $this->orm->findOne([
            "id" => 16,
            "name" => "John"
        ]);
    
        return $result;
    }
}
```
`findOneOrWhere()`
This takes in two arguments with the second argument being the OR condition and returns only one result
```php
require_once __DIR__ . '/vendor/autoload.php';
use SmyORM\SmyORM\Orm;

class User{
    private $orm;

    public function __construct() {
        $this->setUp();
    }

    public function setUp(): void {
        $db = new \PDO('mysql:host=localhost;dbname=yourDatabaseName', 'username', 'password');

        // Create a concrete class that extends the ORM class
        $this->orm = new class($db) extends Orm {
            public function tableName(): string {
                return 'users'; // the name of the table that this model references
            }

            public function attributes(): array {
                return ['name', 'email', 'role']; // attributes of the table
            }
        };
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
}
```
`findAll()`
This performs the basic SELECT all functionality 
```php
require_once __DIR__ . '/vendor/autoload.php';
use SmyORM\SmyORM\Orm;

class User{
    private $orm;

    public function __construct() {
        $this->setUp();
    }

    public function setUp(): void {
        $db = new \PDO('mysql:host=localhost;dbname=yourDatabaseName', 'username', 'password');

        // Create a concrete class that extends the ORM class
        $this->orm = new class($db) extends Orm {
            public function tableName(): string {
                return 'users'; // the name of the table that this model references
            }

            public function attributes(): array {
                return ['name', 'email', 'role']; // attributes of the table
            }
        };
    }
     public function testFindAll() {
        // Call the findAll() method
        $result = $this->orm->findAll();
    
        return $result;
    }
}
```
`findAllWhere()`
This performs the findAll functionality with a WHERE clause
```php
require_once __DIR__ . '/vendor/autoload.php';
use SmyORM\SmyORM\Orm;

class User{
    private $orm;

    public function __construct() {
        $this->setUp();
    }

    public function setUp(): void {
        $db = new \PDO('mysql:host=localhost;dbname=yourDatabaseName', 'username', 'password');

        // Create a concrete class that extends the ORM class
        $this->orm = new class($db) extends Orm {
            public function tableName(): string {
                return 'users'; // the name of the table that this model references
            }

            public function attributes(): array {
                return ['name', 'email', 'role']; // attributes of the table
            }
        };
    }
     public function testfindAllWhere() {
        // Call the findAllWhere() method
        $result = $this->orm->findAllWhere([
            "id" => 1
        ]);
    
        return $result;
    }
}
```
`findAllOrWhere()`
This performs the findAll functionality with a WHERE clause with the second argument being the OR condition 
```php
require_once __DIR__ . '/vendor/autoload.php';
use SmyORM\SmyORM\Orm;

class User{
    private $orm;

    public function __construct() {
        $this->setUp();
    }

    public function setUp(): void {
        $db = new \PDO('mysql:host=localhost;dbname=yourDatabaseName', 'username', 'password');

        // Create a concrete class that extends the ORM class
        $this->orm = new class($db) extends Orm {
            public function tableName(): string {
                return 'users'; // the name of the table that this model references
            }

            public function attributes(): array {
                return ['name', 'email', 'role']; // attributes of the table
            }
        };
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
}
```
`count()`
This counts the number of columns in a table
```php
require_once __DIR__ . '/vendor/autoload.php';
use SmyORM\SmyORM\Orm;

class User{
    private $orm;

    public function __construct() {
        $this->setUp();
    }

    public function setUp(): void {
        $db = new \PDO('mysql:host=localhost;dbname=yourDatabaseName', 'username', 'password');

        // Create a concrete class that extends the ORM class
        $this->orm = new class($db) extends Orm {
            public function tableName(): string {
                return 'users'; // the name of the table that this model references
            }

            public function attributes(): array {
                return ['name', 'email', 'role']; // attributes of the table
            }
        };
    }
    
     public function testCount() {
        // Call the count() method
        $result = $this->orm->count();
    
        return $result;
    }
}
```
`countWhere()`
This counts the number of columns with a WHERE clause
```php
require_once __DIR__ . '/vendor/autoload.php';
use SmyORM\SmyORM\Orm;

class User{
    private $orm;

    public function __construct() {
        $this->setUp();
    }

    public function setUp(): void {
        $db = new \PDO('mysql:host=localhost;dbname=yourDatabaseName', 'username', 'password');

        // Create a concrete class that extends the ORM class
        $this->orm = new class($db) extends Orm {
            public function tableName(): string {
                return 'users'; // the name of the table that this model references
            }

            public function attributes(): array {
                return ['name', 'email', 'role']; // attributes of the table
            }
        };
    }

     public function testcountWhere() {
        // Call the countWhere() method
        $result = $this->orm->countWhere([
            "id" => 1
        ]);
    
        return $result;
    }
}
```
`countOrWhere()`
This counts the number of columns with a WHERE clause and the second argument being the OR condition
```php
require_once __DIR__ . '/vendor/autoload.php';
use SmyORM\SmyORM\Orm;

class User{
    private $orm;

    public function __construct() {
        $this->setUp();
    }

    public function setUp(): void {
        $db = new \PDO('mysql:host=localhost;dbname=yourDatabaseName', 'username', 'password');

        // Create a concrete class that extends the ORM class
        $this->orm = new class($db) extends Orm {
            public function tableName(): string {
                return 'users'; // the name of the table that this model references
            }

            public function attributes(): array {
                return ['name', 'email', 'role']; // attributes of the table
            }
        };
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
}
```
`delete()`
This takes a WHERE clause and deletes a row or rows
```php
require_once __DIR__ . '/vendor/autoload.php';
use SmyORM\SmyORM\Orm;

class User{
    private $orm;

    public function __construct() {
        $this->setUp();
    }

    public function setUp(): void {
        $db = new \PDO('mysql:host=localhost;dbname=yourDatabaseName', 'username', 'password');

        // Create a concrete class that extends the ORM class
        $this->orm = new class($db) extends Orm {
            public function tableName(): string {
                return 'users'; // the name of the table that this model references
            }

            public function attributes(): array {
                return ['name', 'email', 'role']; // attributes of the table
            }
        };
    }

    public function testdelete() {
        // Call the delete() method
        $result = $this->orm->delete([
            "id" => 1
        ]);
    
        return $result;
    }
}
```
`deleteOrWhere()`
This takes a WHERE clause and the second argument being the OR condition then deletes corresponding row or rows
```php
require_once __DIR__ . '/vendor/autoload.php';
use SmyORM\SmyORM\Orm;

class User{
    private $orm;

    public function __construct() {
        $this->setUp();
    }

    public function setUp(): void {
        $db = new \PDO('mysql:host=localhost;dbname=yourDatabaseName', 'username', 'password');

        // Create a concrete class that extends the ORM class
        $this->orm = new class($db) extends Orm {
            public function tableName(): string {
                return 'users'; // the name of the table that this model references
            }

            public function attributes(): array {
                return ['name', 'email', 'role']; // attributes of the table
            }
        };
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
}
```
`update()`
This takes two arguments, the data to be updated and the WHERE clause
```php
require_once __DIR__ . '/vendor/autoload.php';
use SmyORM\SmyORM\Orm;

class User{
    private $orm;

    public function __construct() {
        $this->setUp();
    }

    public function setUp(): void {
        $db = new \PDO('mysql:host=localhost;dbname=yourDatabaseName', 'username', 'password');

        // Create a concrete class that extends the ORM class
        $this->orm = new class($db) extends Orm {
            public function tableName(): string {
                return 'users'; // the name of the table that this model references
            }

            public function attributes(): array {
                return ['name', 'email', 'role']; // attributes of the table
            }
        };
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
}
```
`updateOrWhere()`
This takes three arguments, the data to be updated, a WHERE clause and an OR condition
```php
require_once __DIR__ . '/vendor/autoload.php';
use SmyORM\SmyORM\Orm;

class User{
    private $orm;

    public function __construct() {
        $this->setUp();
    }

    public function setUp(): void {
        $db = new \PDO('mysql:host=localhost;dbname=yourDatabaseName', 'username', 'password');

        // Create a concrete class that extends the ORM class
        $this->orm = new class($db) extends Orm {
            public function tableName(): string {
                return 'users'; // the name of the table that this model references
            }

            public function attributes(): array {
                return ['name', 'email', 'role']; // attributes of the table
            }
        };
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
```
# Contributing & Vulnerabilities
If you would like to contribute or you discover a security vulnerability in the SmyORM, your pull requests are welcome. However, for major changes or ideas on how to improve the library, please create an issue.

# License

The SmyORM is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).