<?php

namespace Kurneo\Support\Exceptions;

use Exception;

class ManagerException extends Exception
{

    /**
     * @param string $class
     * @return void
     * @throws ManagerException
     */
    public static function defaultDriverNotFound(string $class): void
    {
        throw new static(sprintf('Unable to resolve default driver for [%s]', $class));
    }

    /**
     * @param string $driver
     * @return void
     * @throws ManagerException
     */
    public static function creatorFunctionNotDefine(string $driver): void
    {
        throw new static(sprintf("Creator function for driver [%s] is not define", $driver));
    }
}