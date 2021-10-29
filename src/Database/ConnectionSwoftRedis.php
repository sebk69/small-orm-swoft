<?php

/**
 * This file is a part of sebk/small-orm-swoft
 * Copyright 2021 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallOrmCore\Database;

use Sebk\SmallOrmCore\ORM\None;
use Swoft\Redis\Redis;

/**
 * Connection to "none" database : use for unit tests
 */
class ConnectionSwoftRedis extends AbstractConnection
{
    /**
     * Connect to database, use existing connection if exists
     */
    public function connect($force = false) {
        throw new \Exception("No need to connect with redis connection : support native Swoft Redis connection");
    }

    /**
     * Execute sql instruction
     * @param $sql
     * @param array $params
     * @param bool $retry
     * @return mixed
     */
    public function execute($sql, $params = array(), $retry = false, $forceConnection = null) {
        if (!isset($params["key"])) {
            throw new \Exception("Fail to query redis : \$param['key'] must be defined");
        }
        
        switch ($sql) {
            case "get":
                return $this->get($params["key"]);
            case "set":
                $this->set($params["key"], isset($params["value"]) ? $params["value"] : "");
                return null;
            default:
                throw new \Exception("Redis instruction not found ! ($sql)");
        }
    }

    /**
     * Get value of a key
     * @param mixed $fullkey
     * @return array
     */
    protected function get(array $fullkey): array
    {
        if (count($fullkey) == 0) {
            throw new \Exception("Redis instruction get with empty key bag");
        }

        if (count($fullkey) == 1) {
            return [json_decode(Redis::get($fullkey[0]), true)];
        }

        $result = [];
        foreach (Redis::mget($fullkey) as $item) {
            $result[] = json_decode($item, true);
        }

        return $result;
    }

    /**
     * Set a value of a key
     * @param string $fullkey
     * @param $value
     * @return $this
     */
    protected function set(array $fullkey, array $value)
    {
        $result = true;
        foreach ($fullkey as $i => $key) {
            if (!Redis::set($key, json_encode($value[$i]))) {
                $result = false;
            }
        }

        if (!$result) {
            throw new \Exception("Redis set failed !");
        }
        
        return $this;
    }

    /**
     * Delete a value of a key
     * @param string $fullkey
     * @return $this
     */
    protected function del(string $fullkey)
    {
        if (!Redis::del($fullkey)) {
            throw new \Exception("Redis del failed !");
        }
        
        return $this;
    }

    /**
     * Start transaction
     * @return $this
     * @throws ConnectionException
     * @throws TransactionException
     */
    public function startTransaction()
    {
        throw new \Exception("Redis connection does not support transactions");
    }

    /**
     * Commit transaction
     * @return $this
     * @throws TransactionException
     */
    public function commit()
    {
        throw new \Exception("Redis connection does not support transactions");
    }

    /**
     * Rollback transaction
     * @return $this
     * @throws ConnectionException
     * @throws TransactionException
     */
    public function rollback()
    {
        throw new \Exception("Redis connection does not support transactions");
    }

    /**
     * Get last insert id
     * @return int
     */
    public function lastInsertId()
    {
        throw new \Exception("Redis connection does not support last insert id");
    }

}
