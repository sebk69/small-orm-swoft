<?php

/**
 * This file is a part of sebk/small-orm-swoft
 * Copyright 2021 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallOrmSwoft\Generator;

use Sebk\SmallOrmSwoft\Compatibility\ServiceDecorator;
use Sebk\SmallOrmSwoft\Compatibility\SymfonyContainer;

/**
 * Decorator for sebk_small_orm_generator service
 */
class DaoGenerator extends ServiceDecorator
{

    /**
     * Initialize core instance
     */
    public function initCore()
    {
        return new \Sebk\SmallOrmCore\Generator\DaoGenerator(
            bean('sebk_small_orm_dao')->getCoreInstance(),
            bean('sebk_small_orm_connections')->getCoreInstance(),
            SymfonyContainer::getInstance(),
            config("sebk_small_orm.bundles"),
        );
    }

}
