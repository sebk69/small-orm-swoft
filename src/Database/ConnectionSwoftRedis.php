<?php

/**
 * This file is a part of sebk/small-orm-core
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
    public function execute($sql, $params = array(), $retry = false) {
        if (!isset($params["key"])) {
            throw new \Exception("Fail to query redis : \$param['key'] must be defined");
        }
        
        switch ($sql) {
            case "get":
                return $this->get($params["key"]);
            case "set":
                $this->set($params["key"], isset($params["value"]) ? $params["value"] : "");
            default:
                throw new \Exception("Redis instruction not found ! ($sql)");
        }
    }

    /**
     * Get value of a key
     * @param mixed $fullkey
     * @return mixed
     */
    protected function get(array $keys): \stdClass
    {
        if (count($keys) == 0) {
            throw new \Exception("Redis instruction get with empty key bag");
        }
        
        if (count($keys) == 1) {
            return [json_decode(Redis::get($fullkey), false)];
        }
        
        return json_decode(Redis::mget($fullkey), false);
    }

    /**
     * Set a value of a key
     * @param string $fullkey
     * @param $value
     * @return $this
     */
    protected function set(string $fullkey, $value)
    {
        Redis::set($fullkey, json_encode($value));
        
        return $this;
    }

    /**
     * Delete a value of a key
     * @param string $fullkey
     * @return $this
     */
    protected function del(string $fullkey)
    {
        Redis::del($fullkey);
        
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
