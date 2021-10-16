<?php

namespace Sebk\SmallOrmSwoft\Factory;

/**
 * Decorator to expose sebk_small_orm_connections service
 */
class Connections
{
    /** @var \Sebk\SmallOrmCore\Factory\Connections */
    protected static $connections = null;

    /** @var array */
    public $config;

    /** @var string */
    public $defaultConnection;

    /**
     * Get the instance for core
     * @return \Sebk\SmallOrmCore\Factory\Dao
     */
    public function getCoreInstance(): \Sebk\SmallOrmCore\Factory\Connections
    {
        $this->initCore();

        return self::$connections;
    }

    /**
     * Get a connection
     * @param string $connectionName
     * @return \Sebk\SmallOrmCore\Database\Connection
     * @throws \Sebk\SmallOrmCore\Factory\ConfigurationException
     */
    public function get($connectionName = 'default')
    {
        $this->initCore();

        return $this->connections->get($connectionName);
    }

    /**
     * Get list of connections names
     * @return array
     */
    public function getNamesAsArray()
    {
        $this->initCore();

        return $this->connections->getNamesAsArray();
    }

    /**
     * Create core connections factory if not exists
     */
    private function initCore()
    {
        if (self::$connections === null) {
            $this->config = \Swoft::getBean("config")->get("sebk_small_orm.connections");
            self::$connections = new \Sebk\SmallOrmCore\Factory\Connections($this->config, $this->defaultConnection);
        }
    }
}
