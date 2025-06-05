<?php

namespace App;

use PDO;

class Database
{
    public static function conectar(): PDO
    {
        return new PDO('mysql:host=localhost;dbname=seubanco;charset=utf8', 'usuario', 'senha', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
}
