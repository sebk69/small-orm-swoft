<?php

namespace Sebk\SmallOrmSwoft\Factory;

use Sebk\SmallOrmSwoft\Compatibility\SymfonyContainer;

/**
 * Decorator for sebk_small_orm_dao service
 * @method get($bundle, $model)
 */
class Dao
{
    /** @var \Sebk\SmallOrmCore\Factory\Dao */
    protected static $dao;

    /**
     * Get the instance for core
     * @return \Sebk\SmallOrmCore\Factory\Dao
     */
    public function getCoreInstance(): \Sebk\SmallOrmCore\Factory\Dao
    {
        $this->initCore();

        return self::$dao;
    }

    /**
     * Redirect calls to core dao factory
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        $this->initCore();

        return self::$dao->$name(...$arguments);
    }

    private function initCore()
    {
        if (self::$dao === null) {
            self::$dao = new \Sebk\SmallOrmCore\Factory\Dao(
                bean('sebk_small_orm_connections')->getCoreInstance(),
                config('sebk_small_orm.bundles'),
                SymfonyContainer::getInstance()
            );
        }
    }
}
