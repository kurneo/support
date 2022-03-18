<?php


namespace Kurneo\Support\Tests;

use Illuminate\Contracts\Cache\Factory;
use Kurneo\Support\Cache;
use Kurneo\Support\Contracts\CacheFileManager;
use Mockery;
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{
    /**
     * @var string
     */
    protected string $cacheFile = __DIR__ . '/cache-test-file.json';

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
        if (file_exists($this->cacheFile)) {
            unlink($this->cacheFile);
        }
    }

    public function testStoreAndDeleteCacheKey()
    {
        $cacheFactory = Mockery::mock(Factory::class);
        $cache = new Cache(
            $cacheFactory,
            new \Kurneo\Support\CacheFileManager(),
            'test-group',
            ['expired_time' => 3600, 'cache_keys_file' => $this->cacheFile]
        );
        $cache->storeCacheKey('test-key-1');
        $cache->storeCacheKey('test-key-2');
        $this->assertFileExists($this->cacheFile);
        $this->assertSame([
            'test-group' => [
                'test-key-1',
                'test-key-2'
            ]
        ], json_decode(file_get_contents($this->cacheFile), true));

        $this->assertTrue($cache->deleteCacheKey('test-key-1'));
        $this->assertSame([
            'test-group' => [
                'test-key-2'
            ]
        ], json_decode(file_get_contents($this->cacheFile), true));
    }

    public function testPut()
    {
        $key = 'test-key';
        $value = 'test';
        $group = 'test-group';
        $cacheFactory = Mockery::mock(Factory::class);
        $cacheFactory
            ->shouldReceive('put')
            ->with(md5($group) . '-' . $key, $value, 3600)
            ->andReturn(true);

        $cacheFileManager = Mockery::mock(CacheFileManager::class);
        $cacheFileManager->shouldReceive('setFilePath')
            ->once()
            ->with($this->cacheFile)
            ->andReturn($cacheFileManager);
        $cacheFileManager->shouldReceive('fileExists')
            ->once()
            ->withNoArgs()
            ->andReturn(true);
        $cacheFileManager->shouldReceive('getContent')
            ->once()
            ->withNoArgs()
            ->andReturn([]);
        $cacheFileManager->shouldReceive('writeContent')
            ->once()
            ->with([
                $group => [
                    md5($group) . '-' . $key
                ]
            ])
            ->andReturn(true);

        $cache = new Cache(
            $cacheFactory,
            $cacheFileManager,
            $group,
            ['expired_time' => 3600, 'cache_keys_file' => $this->cacheFile]
        );

        $this->assertTrue($cache->put($key, $value));
    }

    /**
     * @return void
     */
    public function testGet()
    {
        $key = 'test-key';
        $key2 = 'test-key-2';
        $value = 'test';
        $group = 'test-group';

        $cacheFactory = Mockery::mock(Factory::class);
        $cacheFactory->shouldReceive('get')
            ->with(md5($group) . '-' . $key)
            ->andReturn($value);
        $cacheFactory->shouldReceive('get')
            ->with(md5($group) . '-' . $key2)
            ->andReturn(null);

        $cacheFileManager = Mockery::mock(CacheFileManager::class);
        $cacheFileManager->shouldReceive('setFilePath')
            ->once()
            ->with($this->cacheFile)
            ->andReturn($cacheFileManager);
        $cacheFileManager->shouldReceive('fileExists')
            ->twice()
            ->withNoArgs()
            ->andReturn(true);

        $cache = new Cache(
            $cacheFactory,
            $cacheFileManager,
            $group,
            ['expired_time' => 3600, 'cache_keys_file' => $this->cacheFile]
        );
        $this->assertEquals($value, $cache->get($key));
        $this->assertNull($cache->get($key2));
    }

    /**
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testHas()
    {
        $key = 'test-key';
        $key2 = 'test-key-1';
        $group = 'test-group';

        $cacheFactory = Mockery::mock(Factory::class);
        $cacheFactory->shouldReceive('has')
            ->once()
            ->with(md5($group) . '-' . $key)
            ->andReturn(true);
        $cacheFactory->shouldReceive('has')
            ->once()
            ->with(md5($group) . '-' . $key2)
            ->andReturn(false);

        $cacheFileManager = Mockery::mock(CacheFileManager::class);
        $cacheFileManager->shouldReceive('setFilePath')
            ->once()
            ->with($this->cacheFile)
            ->andReturn($cacheFileManager);
        $cacheFileManager->shouldReceive('fileExists')
            ->twice()
            ->withNoArgs()
            ->andReturn(true);

        $cache = new Cache(
            $cacheFactory,
            $cacheFileManager,
            $group,
            ['expired_time' => 3600, 'cache_keys_file' => $this->cacheFile]
        );
        $this->assertTrue($cache->has($key));
        $this->assertFalse($cache->has($key2));
    }

    /**
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testDelete()
    {
        $key = 'test-key';
        $value = 'test';
        $group = 'test-group';

        $cacheFactory = Mockery::mock(Factory::class);
        $cacheFactory->shouldReceive('delete')
            ->once()
            ->with(md5($group) . '-' . $key)
            ->andReturn(true);
        $cacheFactory->shouldReceive('delete')
            ->once()
            ->with(md5($group) . '-test-test')
            ->andReturn(false);

        $cacheFileManager = Mockery::mock(CacheFileManager::class);
        $cacheFileManager->shouldReceive('setFilePath')
            ->once()
            ->with($this->cacheFile)
            ->andReturn($cacheFileManager);
        $cacheFileManager->shouldReceive('fileExists')
            ->times(3)
            ->withNoArgs()
            ->andReturn(true);
        $cacheFileManager->shouldReceive('fileExists')
            ->once()
            ->withNoArgs()
            ->andReturn(true);
        $cacheFileManager->shouldReceive('getContent')
            ->twice()
            ->withNoArgs()
            ->andReturn([$group => [
                md5($group) . '-' . $key
            ]]);
        $cacheFileManager->shouldReceive('writeContent')
            ->once()
            ->with([$group => []])
            ->andReturn(true);

        $cache = new Cache(
            $cacheFactory,
            $cacheFileManager,
            $group,
            ['expired_time' => 3600, 'cache_keys_file' => $this->cacheFile]
        );

        $this->assertTrue($cache->delete($key));
        $this->assertFalse($cache->delete('test-test'));
    }

    public function testFlush()
    {
        $key = 'test-key';
        $value = 'test';
        $group = 'test-group';

        $cacheFactory = Mockery::mock(Factory::class);
        $cacheFactory->shouldReceive('forget')
            ->once()
            ->with(md5($group) . '-' . $key)
            ->andReturn(true);

        $cacheFileManager = Mockery::mock(CacheFileManager::class);
        $cacheFileManager->shouldReceive('setFilePath')
            ->once()
            ->with($this->cacheFile)
            ->andReturn($cacheFileManager);
        $cacheFileManager->shouldReceive('fileExists')
            ->once()
            ->withNoArgs()
            ->andReturn(true);
        $cacheFileManager->shouldReceive('getContent')
            ->once()
            ->withNoArgs()
            ->andReturn([
                $group => [
                    md5($group) . '-' . $key
                ]
            ]);
        $cacheFileManager->shouldReceive('writeContent')
            ->once()
            ->with([])
            ->andReturn(true);

        $cache = new Cache(
            $cacheFactory,
            $cacheFileManager,
            $group,
            ['expired_time' => 3600, 'cache_keys_file' => $this->cacheFile]
        );

        $this->assertTrue($cache->flush());
    }
}
