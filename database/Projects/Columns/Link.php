<?php

namespace Database\Projects\Columns;

use CommandString\JsonDb\Structure\Column;
use CommandString\JsonDb\Structure\DataTypes;

class Link extends Column {
    protected static DataTypes $type = DataTypes::STRING;
    protected static string $name = "link";
    protected static bool $nullable = true;
}