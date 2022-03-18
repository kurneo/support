<?php

namespace Kurneo\Support\Exceptions;

use Exception;

class HookException extends Exception
{
    /**
     * @param string $calledClass
     * @throws HookException
     */
    public static function priorityInvalid(string $calledClass): void
    {
        throw new static('Priority must greater than 0 ' . $calledClass);
    }
}