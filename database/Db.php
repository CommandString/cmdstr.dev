<?php

namespace Database;
use CommandString\JsonDb\Structure\Database;
use Database\Projects\Projects;

/**
 * @property-read Projects $projects
 */
class Db extends Database {
    protected static array $tableClasses = [Projects::class];
}