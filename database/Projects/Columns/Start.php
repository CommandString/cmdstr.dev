<?php

namespace Database\Projects\Columns;

use CommandString\JsonDb\Structure\Column;
use CommandString\JsonDb\Structure\DataTypes;

class Start extends Column {
    protected static DataTypes $type = DataTypes::INT;
    protected static string $name = "start";
}