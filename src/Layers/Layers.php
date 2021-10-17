<?php

/**
 * This file is a part of sebk/small-orm-swoft
 * Copyright 2021 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallOrmSwoft\Layers;

use Sebk\SmallOrmSwoft\Compatibility\CoreServiceDecorator;
use Sebk\SmallOrmSwoft\Compatibility\SymfonyContainer;

/**
 * Decorator for sebk_small_orm_layers service
 */
class Layers extends CoreServiceDecorator
{

    /**
     * Initialize core instance
     */
    public function initCore()
    {
        return new \Sebk\SmallOrmCore\Layers\Layers(
            bean('sebk_small_orm_connections')->getCoreInstance(),
            config('sebk_small_orm.bundles'),
            SymfonyContainer::getInstance()
        );
    }

}
