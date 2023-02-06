<?php

namespace Database\Projects\Columns;

use CommandString\JsonDb\Structure\Column;
use CommandString\JsonDb\Structure\DataTypes;

class Thumbnail extends Column {
    protected static DataTypes $type = DataTypes::STRING;
    protected static string $name = "thumbnail";
    protected static string $nullable = true;
}