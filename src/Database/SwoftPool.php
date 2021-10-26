<?php

/**
 * This file is a part of small-orm-swoft
 * Copyright 2021 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallOrmSwoft\Database;

use Swoft\Db\Pool;

class SwoftPool extends Pool
{
    public function __construct(SwoftDatabase $database)
    {
        $this->database = $database;
    }
}
