<?php

namespace Sebk\SmallOrmSwoft\Compatibility;

class Kernel
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
