<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
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
class AddTableCommand
{
    /**
     * @CommandMapping("add-table")
     */
    public function addTableCommand(): void
    {
        $connectionName = input()->getOption('connection', 'default');
        $bundle = input()->getOption('bundle', null);
        $dbTableName = input()->getOption('table', null);

        if ($bundle == null) {
            output()->writeln('--bundle option is mandatory');
        }

        if ($dbTableName == null) {
            output()->writeln('--table option is mandatory');
        }

        if (input()->hasOpt("h") || input()->hasOpt("help")) {
            output()->writeln('Generate dao and model classes by reverse ingeniering from database for a table
--connection : connection name (default if no option)
--bundle : bundle name (mandatory)
--table : table name (mandatory), "all" for create all tables dao
');
        }

        // add selected tables
        if($dbTableName != "all") {
            $this->addSingleTable($connectionName, $bundle, $dbTableName);
        } else {
            $connection = bean("sebk_small_orm_connections")->get($connectionName);
            $dbGateway = new DbGateway($connection);

            foreach($dbGateway->getTables() as $dbTableName) {
                $this->addSingleTable($connectionName, $bundle, $dbTableName);
            }
        }
    }

    /**
     * Add table to bundle
     * @param $connectionName
     * @param $bundle
     * @param $dbTableName
     */
    protected function addSingleTable($connectionName, $bundle, $dbTableName)
    {
        /** @var DaoGenerator $daoGenrator */
        $daoGenrator = bean("sebk_small_orm_generator");
        $daoGenrator->setParameters($connectionName, $bundle);
        $daoGenrator->recomputeFilesForTable($dbTableName);
        $config = new Config($bundle, $connectionName, SymfonyContainer::getInstance());
        $config->addTable($dbTableName);
    }

}
