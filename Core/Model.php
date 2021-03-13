<?php


namespace Core;


use App\Models\Entity\Post;
use PDO;
use PDOException;
use App\Config;

abstract class Model
{
    protected static function getDB()
    {
        static $db = null;
        if ($db === null) {
            try {
                $db = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME,
                    Config::DB_USER, Config::DB_PASSWORD);

                // throw exception when an error occurs
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        return $db;
    }
}