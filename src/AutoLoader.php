<?php declare(strict_types=1);


namespace Sebk\SmallOrmSwoft;


use Sebk\SmallOrmCore\Factory\Connections;
use Sebk\SmallOrmCore\Factory\Dao;
use Sebk\SmallOrmCore\Factory\Validator;
use Sebk\SmallOrmCore\Generator\DaoGenerator;
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
            'sebk_small_orm_connections' => [
                'class' => Connections::class,
                'config' => bean('sebk_small_orm.connexions'),
                'defaultConnection' => 'default',
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
