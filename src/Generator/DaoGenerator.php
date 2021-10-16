<?php

namespace Sebk\SmallOrmSwoft\Generator;

use Sebk\SmallOrmSwoft\Compatibility\SymfonyContainer;

/**
 * Decorator for sebk_small_orm_generator service
 */
class DaoGenerator
{
    /**
     * @var \Sebk\SmallOrmCore\Generator\DaoGenerator
     */
    protected static $generator;

    /**
     * Redirect calls to core dao factory
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        if (self::$generator === null) {
            self::$generator = new \Sebk\SmallOrmCore\Generator\DaoGenerator(
                bean('sebk_small_orm_dao')->getCoreInstance(),
                bean('sebk_small_orm_connections')->getCoreInstance(),
                SymfonyContainer::getInstance(),
                config("sebk_small_orm.bundles"),
            );
        }

        return self::$generator->$name(...$arguments);
    }

}
