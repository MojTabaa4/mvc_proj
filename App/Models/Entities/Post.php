<?php

namespace App\Models\Entities;

use PDO;
use PDOException;

class Post extends \Core\Model
{
    public static function getAll(): array
    {
        try {
            $db = static::getDb();
            $statement = $db->query("SELECT id, title, content from posts order by created_at");
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}