<?php

namespace Kurneo\Support;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use RuntimeException;

class Helper
{
    /**
     * Autoload php files
     *
     * @param $paths
     */
    public static function requireOnce(...$paths)
    {
        foreach ($paths as $path) {
            $path = realpath($path);
            if (!$path)
                throw new RuntimeException(sprintf('Path %s doesnt exists', $path));
            require_once $path;
        }
    }

    /**
     * Autoload all php file in given directory
     *
     * @param string $path
     * @param array $excepts
     */
    public static function autoLoad(string $path, array $excepts = [])
    {
        $files = File::glob($path . DIRECTORY_SEPARATOR . '*.php');

        foreach ($files as $file) {
            if (!in_array($file, $excepts)) require_once $file;
        }
    }

    /**
     * @param string $command
     * @param array $parameters
     * @param null $outputBuffer
     * @return int
     */
    public static function execCommand(string $command, array $parameters = [], $outputBuffer = null): int
    {
        return Artisan::call($command, $parameters, $outputBuffer);
    }
}
