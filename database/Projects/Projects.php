<?php

namespace Database\Projects;
use CommandString\JsonDb\Structure\Table;
use Database\Projects\Columns\Description;
use Database\Projects\Columns\End;
use Database\Projects\Columns\Link;
use Database\Projects\Columns\Name;
use Database\Projects\Columns\Start;
use Database\Projects\Columns\Thumbnail;

class Projects extends Table {
    public const NAME = "name";
    public const DESCRIPTION = "description";
    public const START = "start";
    public const END = "end";
    public const LINK = "link";
    public const THUMBNAIL = "thumbnail";

    protected static string $name = "projects";
    protected static string $fileLocation = __DIR__."/projects.json";
    protected static array $columns = [Name::class, Description::class, Start::class, End::class, Link::class, Thumbnail::class];
}