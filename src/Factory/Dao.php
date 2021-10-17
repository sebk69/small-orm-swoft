<?php

/**
 * This file is a part of sebk/small-orm-swoft
 * Copyright 2021 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallOrmSwoft\Factory;

use Sebk\SmallOrmSwoft\Compatibility\CoreServiceDecorator;
use Sebk\SmallOrmSwoft\Compatibility\SymfonyContainer;

/**
 * Decorator for sebk_small_orm_dao service
 * @method get($bundle, $model, $useConnection = null)
 * @method reset()
 * @method mock(string $bundle, string $dao, string $class)
 * @method getDaoDir($bundle, $connection)
 * @method getDaoFullClassName($connectionNameOfDao, $bundle, $model)
 * @method getDaoNamespace($connectionNameOfDao, $bundle)
 * @method getModelFullClassName($connectionNameOfDao, $bundle, $model)
 * @method getModelNamespace($connectionNameOfDao, $bundle)
 * @method getFile($connectionNameOfDao, $bundle, $model, $evenIfNotFound = false)
 * @method getModelFile($connectionNameOfDao, $bundle, $model, $evenIfNotFound = false)
 */
class Dao extends CoreServiceDecorator
{

    /**
     * Initialize core instance
     */
    public function initCore()
    {
        return new \Sebk\SmallOrmCore\Factory\Dao(
            bean('sebk_small_orm_connections')->getCoreInstance(),
            config('sebk_small_orm.bundles'),
            SymfonyContainer::getInstance()
        );
    }

}
