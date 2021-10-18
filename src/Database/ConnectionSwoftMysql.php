<?php
/**
 * This file is a part of small-orm-swoft
 * Copyright 2021 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallOrmSwoft\Database;

use Sebk\SmallOrmCore\Database\AbstractConnection;
use Sebk\SmallOrmCore\Database\ConnectionException;

/**
 * Connection to mysql database via swoft connector
 */
class ConnectionSwoftMysql extends AbstractConnection
{
    /** @var SwoftDatabase */
    protected $database;

    /** @var SwoftPool */
    protected $pool;

    protected $transactionConnection;

    public function __construct($dbType, $host, $database, $user, $password, $encoding, $createDatabase = false)
    {
        $this->database = new SwoftDatabase($database, $host, $user, $password, $encoding);
        $this->pool = new SwoftPool($this->database);

        parent::__construct($dbType, $host, $database, $user, $password, $encoding, $createDatabase);
    }

    public function connect($force = false)
    {
        if ($force) {
            $this->database = new SwoftDatabase($this->database, $this->host, $this->user, $this->password, $this->encoding);
            $this->pool = new SwoftPool($this->database);
        }

        return $this->pool->createConnection();
    }

    /**
     * Execute sql instruction
     * @param $sql
     * @param array $params
     * @param bool $retry
     * @return mixed
     * @throws ConnectionException
     */
    public function execute($sql, $params = array(), $retry = false)
    {
        if (strtolower($sql) == "start transaction") {
            $this->transactionConnection = $connexion = $this->connect();
        } elseif ($this->transactionInUse) {
            $connexion = $this->transactionConnection;
        } else {
            $connexion = $this->connect();
        }


        $statement = $connexion->getPdo()->prepare($sql);

        foreach ($params as $param => $value) {
            $statement->bindValue(":" . $param, $value);
        }
        if ($statement->execute()) {
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            $errInfo = $statement->errorInfo();
            throw new ConnectionException("Fail to execute request : SQLSTATE[" . $errInfo[0] . "][" . $errInfo[1] . "] " . $errInfo[2]);
        }
    }

    /**
     * Start transaction
     * @return $this
     * @throws ConnectionException
     * @throws TransactionException
     */
    public function startTransaction()
    {
        if($this->getTransactionInUse()) {
            throw new TransactionException("Transaction already started");
        }

        $this->execute("START TRANSACTION");
        $this->transactionInUse = true;

        return $this;
    }

    /**
     * Commit transaction
     * @return $this
     * @throws ConnectionException
     * @throws TransactionException
     */
    public function commit()
    {
        if(!$this->getTransactionInUse()) {
            throw new TransactionException("Transaction not started");
        }

        $this->execute("COMMIT");

        $this->transactionInUse = false;

        return $this;
    }

    /**
     * Rollback transaction
     * @return $this
     * @throws ConnectionException
     * @throws TransactionException
     */
    public function rollback()
    {
        if(!$this->getTransactionInUse()) {
            throw new TransactionException("Transaction not started");
        }

        $this->execute("ROLLBACK");

        $this->transactionInUse = false;

        return $this;
    }

    /**
     * Get last insert id
     * @return int
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
