<?php

namespace Sebk\SmallOrmSwoft\Database;

use Swoft\Db\Database;

class SwoftDatabase extends Database
{
    public function __construct($database, $host, $user, $password, $encoding) {
        $this->dsn = "mysql:dbname=$database;host=$host";
        $this->charset = $encoding;
        $this->username = $user;
        $this->password = $password;
        $this->config = ['fetchMode' => \PDO::FETCH_ASSOC];
    }
}
