<?php

namespace App\Database;

use PDO;

class Database{

    protected static $pdo;

    public static function connect()
    {
        if(!static::$pdo)
        {
            $config = include 'config.php';
            static::$pdo = new PDO ('mysql:host=' . $config['db_host'] .';dbname=' . $config['db_name'] , $config['db_user'], $config['db_password']);
        }
    }

    public static function getPdo()
    {
        static::connect();
        return static::$pdo;
    }

    public static function queryAll($sql, $className = null){
        $result = static::getPdo()->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function query($sql)
    {
        $result = static::getPdo()->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function prepare($sql)
    {
        return static::getPdo()->prepare($sql);
    }
}