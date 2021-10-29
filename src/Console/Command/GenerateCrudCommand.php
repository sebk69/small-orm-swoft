<?php declare(strict_types=1);

/**
 * This file is a part of sebk/small-orm-swoft
 * Copyright 2021 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallOrmSwoft\Console\Command;

use Sebk\SmallOrmCore\Dao\AbstractDao;
use Sebk\SmallOrmSwoft\Traits\Injection\DaoFactory;
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
class GenerateCrudCommand
{
    use DaoFactory;

    /**
     * @CommandMapping("generate:crud")
     */
    public function generateCrud(): void
    {
        // Check required packages
        if (!function_exists('JsonResponse')) {
            throw new \Exception('The \'sebk/swoft-json-response\' is required by CRUD generator');
        }
        if (!class_exists('\Sebk\SmallOrmForms\Form\FormModel')) {
            throw new \Exception('The \'sebk/small-orm-forms\' is required by CRUD generator');
        }

        // Get parameters
        $bundle = input()->getOption('bundle', null);
        $model = input()->getOption('model', null);

        if ($bundle == null) {
            output()->writeln('--bundle option is mandatory');
            exit;
        }

        if ($model == null) {
            output()->writeln('--model option is mandatory');
            exit;
        }

        // Get dao
        /** @var AbstractDao $dao */
        $dao = $this->daoFactory->get($bundle, $model);

        // Get id field (for now, only on id field is managed)
        /** @var Field $primaryKey */
        foreach ($dao->getPrimaryKeys() as $primaryKey) {
            $idField = $primaryKey->getModelName();
            break;
        }

        // Get full model class
        $fullModelClass = $this->daoFactory->getModelNamespace("default", $bundle) . "\\" . $model;

        // Get filepath
        $filePath = config("sebk_small_orm.crudBasePath") . $model . "Controller.php";

        // Generate controller
        $this->generateFile($filePath, $bundle, $model, $idField, $fullModelClass);
    }

    /**
     * Generate crud file with parameters
     * @param $filePath
     * @param $bundleName
     * @param $modelName
     * @param $idField
     * @param $fullModelClass
     */
    private function generateFile($filePath, $bundleName, $modelName, $idField, $fullModelClass)
    {
        ob_start();
        include __DIR__ . '/../../View/CrudGenerator/controller';
        $content = "<?php\n" . ob_get_contents();
        ob_end_clean();

        file_put_contents($filePath, $content);
    }


}
