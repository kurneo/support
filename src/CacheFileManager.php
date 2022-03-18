<?php

namespace Kurneo\Support;

use Kurneo\Support\Contracts\CacheFileManager as CacheFileManagerContract;
use Kurneo\Support\Exceptions\IOException;

class CacheFileManager implements CacheFileManagerContract
{
    /**
     * @var string
     */
    protected string $filePath;

    /**
     * @param string $path
     * @return $this
     */
    public function setFilePath(string $path): self
    {
        $this->filePath = $path;
        return $this;
    }

    /**
     * @return array
     */
    public function getContent(): array
    {
        return json_decode(@file_get_contents($this->filePath), true) ?? [];
    }

    /**
     * @param array $data
     * @return void
     * @throws IOException
     */
    public function writeContent(array $data): void
    {
        if (file_put_contents($this->filePath, json_encode($data)) === false) {
            throw new IOException('Cannot write to file: %s.', $this->filePath);
        }
    }

    /**
     * @return bool
     */
    public function fileExists(): bool
    {
        return file_exists($this->filePath);
    }
}
