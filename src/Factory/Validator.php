<?php

/**
 * This file is a part of sebk/small-orm-swoft
 * Copyright 2021 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallOrmSwoft\Factory;

use Sebk\SmallOrmSwoft\Compatibility\CoreServiceDecorator;

/**
 * Decorator for sebk_small_orm_validator service
 * @method get(Model $model)
 */
class Validator extends CoreServiceDecorator
{

    public function initCore()
    {
        return new \Sebk\SmallOrmCore\Factory\Validator(
            bean('sebk_small_orm_dao')->getCoreInstance(),
            config('sebk_small_orm.bundles')
        );
    }

}
