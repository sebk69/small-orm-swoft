<?php

/**
 * This file is a part of sebk/small-orm-swoft
 * Copyright 2021 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallOrmSwoft\Factory;

use Sebk\SmallOrmSwoft\Compatibility\CoreServiceDecorator;

/**
 * Decorator to expose sebk_small_orm_connections service
 * @method get($connectionName = 'default')
 * @method getNamesAsArray()
 */
class Connections extends CoreServiceDecorator
{

    /** @var string */
    public $defaultConnection;

    /**
     * Initialize core instance
     */
    public function initCore()
    {
        \Sebk\SmallOrmCore\Factory\Connections::$namespaces[] = '\Sebk\SmallOrmSwoft\Database\\';
        return new \Sebk\SmallOrmCore\Factory\Connections(
            config("sebk_small_orm.connections"),
            $this->defaultConnection
        );
    }
}
