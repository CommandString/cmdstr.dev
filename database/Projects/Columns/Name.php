<?php

namespace Database\Projects\Columns;

use CommandString\JsonDb\Structure\Column;
use CommandString\JsonDb\Structure\DataTypes;

class Name extends Column {
    protected static DataTypes $type = DataTypes::STRING;
    protected static string $name = "name";
}