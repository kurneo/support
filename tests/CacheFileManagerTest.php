<?php

namespace Kurneo\Support\Tests;

use Kurneo\Support\Contracts\CacheFileManager;
use Kurneo\Support\Exceptions\IOException;
use PHPUnit\Framework\TestCase;

class CacheFileManagerTest extends TestCase
{
    /**
     * @var CacheFileManager
     */
    protected CacheFileManager $cacheFileManager;

    /**
     * @var string
     */
    protected string $filePath = __DIR__ . '/test.json';

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->cacheFileManager = new \Kurneo\Support\CacheFileManager();
        $this->cacheFileManager->setFilePath($this->filePath);
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        if (file_exists($this->filePath)) {
            unlink($this->filePath);
        }
    }

    public function testGetFileContent()
    {
        touch($this->filePath);
        $this->assertSame([], $this->cacheFileManager->getContent());
    }

    public function testGetFileNotExist()
    {
        $this->assertSame([], $this->cacheFileManager->getContent());
    }

    /**
     * @return void
     * @throws IOException
     */
    public function testWriteFile()
    {
        touch($this->filePath);
        $content = [
            'test-key' => 'test'
        ];
        $this->assertSame([], $this->cacheFileManager->getContent());
        $this->cacheFileManager->writeContent($content);
        $this->assertSame($content, $this->cacheFileManager->getContent());
    }
}
