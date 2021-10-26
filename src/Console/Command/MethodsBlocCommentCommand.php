<?php declare(strict_types=1);

/**
 * This file is a part of sebk/small-orm-swoft
 * Copyright 2021 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallOrmSwoft\Console\Command;

use Sebk\SmallOrmSwoft\Generator\DaoGenerator;
use Swoft\Console\Annotation\Mapping\Command;
use Swoft\Console\Annotation\Mapping\CommandMapping;
use Swoft\Console\Exception\ConsoleErrorException;
use function input;
use function output;

/**
 * Class MethodsBlocCommentCommand
 *
 * @since 2.0
 *
 * @Command(name="sebk:small-orm",coroutine=false)
 */
class MethodsBlocCommentCommand
{
    /**
     * @CommandMapping("add-methods-bloc-comment")
     */
    public function addMethodsBlocComment(): void
    {
        $connectionName = input()->getOption('connection', 'default');
        $bundle = input()->getOption('bundle', null);
        $daoName = input()->getOption('dao', null);

        if ($bundle == null) {
            output()->writeln('--bundle option is mandatory');
            exit;
        }

        if ($daoName == null) {
            output()->writeln('--dao option is mandatory');
            exit;
        }
        
        /** @var DaoGenerator $daoGenrator */
        $daoGenrator = bean("sebk_small_orm_generator");
        $daoGenrator->setParameters($connectionName, $bundle);
        if($daoName != "all") {
            // Single file
            $daoGenrator->createAtModelMethods($daoName);
        } else {
            // All files
            foreach(scandir(bean("sebk_small_orm_dao")->getDaoDir($bundle, $connectionName)) as $file) {
                if(substr($file, strlen($file) - 4) == ".php") {
                    $daoName = substr($file, 0, strlen($file) - 4);
                    $daoGenrator->createAtModelMethods($daoName);
                }
            }
        }
    }

}
