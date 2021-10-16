<?php declare(strict_types=1);

/**
 * This file is a part of sebk/small-orm-swoft
 * Copyright 2021 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallOrmSwoft\Console\Command;

use Sebk\SmallOrmCore\Generator\Config;
use Sebk\SmallOrmCore\Generator\DaoGenerator;
use Sebk\SmallOrmCore\Generator\DbGateway;
use Sebk\SmallOrmSwoft\Compatibility\SymfonyContainer;
use Swoft\Console\Annotation\Mapping\Command;
use Swoft\Console\Annotation\Mapping\CommandMapping;
use Swoft\Console\Exception\ConsoleErrorException;
use function input;
use function output;

/**
 * Class AddTableCommand
 *
 * @since 2.0
 *
 * @Command(name="sebk:small-orm",coroutine=false)
 */
class LayersExecuteCommand
{
    /**
     * @CommandMapping("layers-execute")
     */
    public function addTableCommand(): void
    {
        $layersService = bean("sebk_small_orm_layers");
        $layersService->execute();
    }

}
