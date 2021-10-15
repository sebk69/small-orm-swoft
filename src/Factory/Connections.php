<?php

namespace Sebk\SmallOrmSwoft\Factory;

class Connections
{
    /** @var \Sebk\SmallOrmCore\Factory\Connections */
    protected $connections = null;

    /** @var array */
    public $config;
    
    /** @var string */
    public $defaultConnection;

    /**
     * Get a connection
     * @param string $connectionName
     * @return \Sebk\SmallOrmCore\Database\Connection
     * @throws \Sebk\SmallOrmCore\Factory\ConfigurationException
     */
    public function get($connectionName = 'default')
    {
        $this->create();
        return $this->connections->get($connectionName);
    }

    /**
     * Get list of connections names
     * @return array
     */
    public function getNamesAsArray()
    {
        $this->create();
        return $this->connections->getNamesAsArray();
    }

    /**
     * Create core connections factory if not exists
     */
    private function create()
    {
        if ($this->connections === null) {
            $this->connections = new \Sebk\SmallOrmCore\Factory\Connections($this->config, $this->defaultConnection);
        }
    }
}