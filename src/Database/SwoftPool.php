<?php

namespace Sebk\SmallOrmSwoft\Database;

use Swoft\Db\Pool;

class SwoftPool extends Pool
{
    public function __construct(SwoftDatabase $database)
    {
        $this->database = $database;
    }
}
