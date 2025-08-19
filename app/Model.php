<?php
// app/Model.php
namespace App;

use PDO;

class Model
{
    protected static $table;
    protected static $primaryKey = 'id';
    protected static $connection;

    public static function setConnection(PDO $pdo)
    {
        static::$connection = $pdo;
    }

    public static function find($id)
    {
        $table = static::$table;
        $pk = static::$primaryKey;
        $stmt = static::$connection->prepare("SELECT * FROM `$table` WHERE `$pk` = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function all()
    {
        $table = static::$table;
        $stmt = static::$connection->query("SELECT * FROM `$table`");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function where($column, $value)
    {
        $table = static::$table;
        $stmt = static::$connection->prepare("SELECT * FROM `$table` WHERE `$column` = :value");
        $stmt->execute(['value' => $value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
