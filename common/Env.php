<?php

namespace Common;

use eftec\bladeone\BladeOne;

class Env extends \CommandString\Env\Env {
    public static function blade(): BladeOne
    {
        return clone Env::get()->blade;
    }
}