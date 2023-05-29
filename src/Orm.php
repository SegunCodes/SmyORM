<?php

namespace SmyORM\SmyORM;
/**
 * SmyORM - SmyORM is a PHP Object-relational mapping (ORM)
 * @author SegunCodes
*/ 
abstract class Orm{
    private $db;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    abstract public function tableName(): string;
    abstract public function attributes(): array;

    public function save(){
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = $this->prepare("INSERT INTO $tableName (".implode(',', $attributes).") 
        VALUES (".implode(',', $params).")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public function findOne($where){
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $stmt = $this->prepare("SELECT * FROM $tableName WHERE $sql"); 
        foreach ($where as $key => $item) {
            $stmt->bindValue(":$key", $item);
        }
        $stmt->execute();
        return $stmt->fetchObject();
    }

    public function findOneOrWhere($where, $orWhere){
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $orpart = array_keys($orWhere); 
        $sql2 = implode(" AND ", array_map(fn($or) => "$or = :$or", $orpart));
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $stmt = $this->prepare("SELECT * FROM $tableName WHERE $sql or $sql2"); 
        foreach ($where as $key => $item) {
            $stmt->bindValue(":$key", $item);
        }
        foreach ($orWhere as $keys => $items) {
            $stmt->bindValue(":$keys", $items);
        }
        $stmt->execute();
        return $stmt->fetchObject();
    }

    public function findAll(){
        $tableName = static::tableName();
        $stmt = $this->prepare("SELECT * FROM $tableName ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findAllWhere($where){
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $stmt = $this->prepare("SELECT * FROM $tableName WHERE $sql ORDER BY id DESC");
        foreach ($where as $key => $item) {
            $stmt->bindValue(":$key", $item);
        }
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findAllOrWhere($where, $orWhere) {
        $tableName = static::tableName();
        $whereConditions = implode(" AND ", array_map(fn($attr) => "$attr = :where_$attr", array_keys($where)));
        $orWhereConditions = implode(" OR ", array_map(fn($attr) => "$attr = :orWhere_$attr", array_keys($orWhere)));
        $sql = "SELECT * FROM $tableName";
        if (!empty($whereConditions)) {
            $sql .= " WHERE $whereConditions";
        }
        if (!empty($orWhereConditions)) {
            if (!empty($whereConditions)) {
                $sql .= " OR $orWhereConditions";
            } else {
                $sql .= " WHERE $orWhereConditions";
            }
        }
        $stmt = $this->prepare($sql);
        foreach ($where as $key => $value) {
            $stmt->bindValue(":where_$key", $value);
        }
        foreach ($orWhere as $key => $value) {
            $stmt->bindValue(":orWhere_$key", $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    

    public function count(){
        $tableName = static::tableName();
        $stmt = $this->prepare("SELECT count(*) FROM $tableName"); 
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function countWhere($where){
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $stmt = $this->prepare("SELECT count(*) FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $stmt->bindValue(":$key", $item);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function countOrWhere($where, $orWhere){
        $tableName = static::tableName();
        $whereConditions = implode(" AND ", array_map(fn($attr) => "$attr = :where_$attr", array_keys($where)));
        $orWhereConditions = implode(" OR ", array_map(fn($attr) => "$attr = :orWhere_$attr", array_keys($orWhere)));
        $sql = "SELECT count(*) FROM $tableName";
        if (!empty($whereConditions)) {
            $sql .= " WHERE $whereConditions";
        }
        if (!empty($orWhereConditions)) {
            if (!empty($whereConditions)) {
                $sql .= " OR $orWhereConditions";
            } else {
                $sql .= " WHERE $orWhereConditions";
            }
        }
        $stmt = $this->prepare($sql);
        foreach ($where as $key => $value) {
            $stmt->bindValue(":where_$key", $value);
        }
        foreach ($orWhere as $key => $value) {
            $stmt->bindValue(":orWhere_$key", $value);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function delete($where){
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $stmt = $this->prepare("DELETE FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $stmt->bindValue(":$key", $item);
        }
        return $stmt->execute();
    }

    public function deleteOrWhere($where, $orWhere){
        $tableName = static::tableName();
        $whereConditions = implode(" AND ", array_map(fn($attr) => "$attr = :where_$attr", array_keys($where)));
        $orWhereConditions = implode(" OR ", array_map(fn($attr) => "$attr = :orWhere_$attr", array_keys($orWhere)));
        $sql = "DELETE FROM $tableName";
        if (!empty($whereConditions)) {
            $sql .= " WHERE $whereConditions";
        }
        if (!empty($orWhereConditions)) {
            if (!empty($whereConditions)) {
                $sql .= " OR $orWhereConditions";
            } else {
                $sql .= " WHERE $orWhereConditions";
            }
        }
        
        $stmt = $this->prepare($sql);
        foreach ($where as $key => $value) {
            $stmt->bindValue(":where_$key", $value);
        }
        foreach ($orWhere as $key => $value) {
            $stmt->bindValue(":orWhere_$key", $value);
        }
        return $stmt->execute();
    }

    public function update($data, $where){
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $set = array_keys($data);
        $setData = implode(", ", array_map(fn($d) => "$d = :$d", $set));
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $stmt = $this->prepare("UPDATE $tableName SET $setData WHERE $sql");
        foreach ($data as $keys => $items) {
            $stmt->bindValue(":$keys", $items);
        }
        foreach ($where as $key => $item) {
            $stmt->bindValue(":$key", $item);
        }
        return $stmt->execute();
    }

    public function updateOrWhere($data, $where, $orWhere) {
        $tableName = static::tableName();
        $set = array_keys($data);
        $whereConditions = implode(" AND ", array_map(fn($attr) => "$attr = :where_$attr", array_keys($where)));
        $orWhereConditions = implode(" OR ", array_map(fn($attr) => "$attr = :orWhere_$attr", array_keys($orWhere)));
        $setData = implode(", ", array_map(fn($d) => "$d = :$d", $set));
        
        $sql = "UPDATE $tableName SET $setData";
        
        if (!empty($whereConditions)) {
            $sql .= " WHERE $whereConditions";
        }
        
        if (!empty($orWhereConditions)) {
            if (!empty($whereConditions)) {
                $sql .= " OR $orWhereConditions";
            } else {
                $sql .= " WHERE $orWhereConditions";
            }
        }
        
        $stmt = $this->prepare($sql);
        
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        
        foreach ($where as $key => $value) {
            $stmt->bindValue(":where_$key", $value);
        }
        
        foreach ($orWhere as $key => $value) {
            $stmt->bindValue(":orWhere_$key", $value);
        }
        
        return $stmt->execute();
    }
    
    public function prepare($sql){
        return $this->db->prepare($sql);
    }
}
