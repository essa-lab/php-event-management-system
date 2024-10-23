<?php

namespace Core;

use PDO;

class Database
{
    public $connection;
    public $statement;

    public function __construct($config)
    {
        //build the dsn my sql connection (mysql:host=xxx.x.x.x;port=xxxx;charset=utf8mb4;dbname=)
        $dsn = 'mysql:' . http_build_query($config, '', ';');

        // store the PDO connection in $connection class property ,making sure it will return data in array format (PDO::FETCH_ASSOC)
        $this->connection = new PDO($dsn, 'issa', 'Password1!', [
           PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function query($query, $params = [],$single = false)
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        return $single ? $this->statement->fetch(PDO::FETCH_ASSOC) : $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }
}
