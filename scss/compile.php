<?php

use CommandString\Utils\FileSystemUtils;
use ScssPhp\ScssPhp\Compiler;

require_once "../vendor/autoload.php";

$currentDirectory = realpath("./");
$outputDirectory = realpath("../public/assets/css");
$files = FileSystemUtils::getAllFilesWithExtensions("./", ["scss"], true);
$directories = FileSystemUtils::getAllSubDirectories("./", true);
$compiler = new Compiler();

foreach ($directories as $directory) {
    $directory_name = str_replace($currentDirectory, "", $directory);
    $directory = $outputDirectory.$directory_name;

    if (!realpath($directory)) {
        echo "Creating $directory...\n";
        mkdir($directory);
    }
}

foreach ($files as $file) {
    $scss_contents = file_get_contents($file);
    $compiled_css = $compiler->compileString($scss_contents)->getCss();
    $outputPath = str_replace(".scss", ".css", str_replace($currentDirectory, $outputDirectory, $file));

    echo "Compiling $file...\n";
    file_put_contents($outputPath, $compiled_css);
}