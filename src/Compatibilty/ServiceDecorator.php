<?php

/**
 * This file is a part of sebk/small-orm-swoft
 * Copyright 2021 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallOrmSwoft\Compatibility;

abstract class ServiceDecorator
{
    protected static $coreInstance = [];

    /**
     * Initialize core instance
     */
    abstract public function initCore();

    /**
     * Get core instance
     * @return \Sebk\SmallOrmCore\Factory\Dao
     */
    public function getCoreInstance()
    {
        if (!isset(self::$coreInstance[get_class($this)])) {
            self::$coreInstance[get_class($this)] = $this->initCore();
        }

        return self::$coreInstance[get_class($this)];
    }

    /**
     * Redirect calls to core
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        $instance = $this->getCoreInstance();

        return $instance->$name(...$arguments);
    }

}
