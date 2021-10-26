<?php

/**
 * This file is a part of sebk/small-swoft-auth
 * Copyright 2021 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallOrmSwoft\Traits\Injection;

use Sebk\SmallOrmSwoft\Factory\Dao;
use Swoft\Bean\Annotation\Mapping\Inject;

trait DaoFactory
{
    /**
     * @Inject()
     *
     * @var Dao
     */
    private $daoFactory;
}
