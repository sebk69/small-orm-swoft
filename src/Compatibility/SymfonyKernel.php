<?php

/**
 * This file is a part of sebk/small-orm-swoft
 * Copyright 2021 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallOrmSwoft\Compatibility;

class SymfonyKernel
{
    public $swoft = true;

    public function locateResource($resource): string
    {
        $path = config("sebk_small_orm.bundlesBasePath") . '/' . str_replace('@', '', $resource);

        if (is_dir($path)) {
            $path .= "/";
        }

        return $path;
    }
}
