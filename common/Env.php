<?php

namespace Common;

use CommandString\Pdo\Driver;
use eftec\bladeone\BladeOne;

class Env extends \CommandString\Env\Env {
    public static function blade(): BladeOne
    {
        return clone Env::get()->blade;
    }

    public static function getDriver(): ?Driver
    {
        return self::get()->driver ?? null;
    }
}