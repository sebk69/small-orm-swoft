<?php declare(strict_types=1);


namespace Sebk\SmallOrmSwoft;


use Sebk\SmallOrmSwoft\Compatibility\Kernel;
use Sebk\SmallOrmSWoft\Factory\Dao;
use Sebk\SmallOrmSWoft\Generator\DaoGenerator;
use Sebk\SmallOrmSwoft\Factory\Connections;
use Swoft\Bean\Container;
use Swoft\Helper\ComposerJSON;
use function bean;
use PDO;
use Swoft\SwoftComponent;

/**
 * Class AutoLoader
 *
 * @since 2.0
 */
class AutoLoader extends SwoftComponent
{
    /**
     * @return array
     */
    public function beans(): array
    {
        return [
            'kernel' => [
                'class' => Kernel::class
            ],
            'sebk_small_orm_connections' => [
                'class' => Connections::class,
                'defaultConnection' => 'default',
                '__option' => ['alias' => 'Sebk\SmallOrmSwoft\Factory\Connections']
            ],
            'sebk_small_orm_dao' => [
                'class' => Dao::class,
                '__option' => ['alias' => 'Sebk\SmallOrmSwoft\Factory\Dao']
            ],
            'sebk_small_orm_generator' => [
                'class' => DaoGenerator::class,
            ],
        ];
    }

    /**
     * @return array
     */
    public function getPrefixDirs(): array
    {
        return [
            __NAMESPACE__ => __DIR__,
        ];
    }

    /**
     * Metadata information for the component.
     *
     * @return array
     * @see ComponentInterface::getMetadata()
     */
    public function metadata(): array
    {
        $jsonFile = dirname(__DIR__) . '/composer.json';

        return ComposerJSON::open($jsonFile)->getMetadata();
    }
}
