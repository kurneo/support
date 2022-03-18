<?php

namespace Kurneo\Support\Contracts;

interface Manager
{
    /**
     * @return array
     */
    public function getDrivers(): array;

    /**
     *
     * Define default driver for create default instance
     *
     * @return string
     */
    public function defaultDriver(): string;
}
