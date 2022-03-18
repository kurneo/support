<?php

namespace Kurneo\Support\Contracts;

interface CacheFileManager
{
    /**
     * @param string $path
     */
    public function setFilePath(string $path);

    /**
     * @return bool
     */
    public function fileExists(): bool;

    /**
     * @return array
     */
    public function getContent(): array;

    /**
     * @param array $data
     * @return void
     */
    public function writeContent(array $data): void;
}