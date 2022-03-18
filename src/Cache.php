<?php declare(strict_types=1);

namespace Kurneo\Support;

use Illuminate\Contracts\Cache\Factory;
use Illuminate\Support\Arr;
use Kurneo\Support\Contracts\Cache as CacheContract;
use Kurneo\Support\Contracts\CacheFileManager;
use Psr\SimpleCache\InvalidArgumentException;

class Cache implements CacheContract
{
    /**
     * @var string
     */
    protected string $group;

    /**
     * @var array
     */
    protected array $config;

    /**
     * @var Factory
     */
    protected Factory $cache;

    /**
     * @var CacheFileManager
     */
    protected CacheFileManager $cacheFileManager;

    /**
     * @param Factory $cache
     * @param CacheFileManager $cacheFileManager
     * @param string $group
     * @param array $config
     */
    public function __construct(
        Factory          $cache,
        CacheFileManager $cacheFileManager,
        string           $group = 'default',
        array            $config = []
    )
    {
        $this->cache = $cache;
        $this->cacheFileManager = $cacheFileManager;
        $this->group = $group;
        $this->config = !empty($config) ? $config : [
            'expired_time' => 3600,
            'cache_keys_file' => 'cache-keys.json'
        ];
        $this->cacheFileManager->setFilePath($this->config['cache_keys_file']);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        if (!$this->cacheFileManager->fileExists()) {
            return null;
        }

        return $this->cache->get($this->getCacheKey($key));
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int|false $ttl
     * @return bool
     */
    public function put(string $key, mixed $value, int|false $ttl = false): bool
    {
        if (!$ttl) {
            $ttl = $this->config['expired_time'];
        }
        $key = $this->getCacheKey($key);
        $this->storeCacheKey($key);
        return $this->cache->put($key, $value, $ttl);
    }

    /**
     * @param string $key
     * @return bool
     * @throws InvalidArgumentException
     */
    public function has(string $key): bool
    {
        if (!$this->cacheFileManager->fileExists()) {
            return false;
        }
        return $this->cache->has($this->getCacheKey($key));
    }

    /**
     * @param string $key
     * @return bool
     * @throws InvalidArgumentException
     */
    public function delete(string $key): bool
    {
        if (!$this->cacheFileManager->fileExists()) {
            return false;
        }
        $key = $this->getCacheKey($key);
        $this->deleteCacheKey($key);
        return $this->cache->delete($key);
    }

    /**
     * @return bool
     */
    public function flush(): bool
    {
        if (!$this->cacheFileManager->fileExists()) {
            return false;
        }
        $keys = $this->cacheFileManager->getContent();
        if (!empty($keys)) {
            foreach (Arr::get($keys, $this->group, []) as $key) {
                $this->cache->forget($key);
            }
            Arr::forget($keys, $this->group);
        }

        $this->cacheFileManager->writeContent($keys);

        return true;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getCacheKey(string $key): string
    {
        return md5($this->group) . '-' . $key;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function storeCacheKey(string $key): bool
    {
        if ($this->cacheFileManager->fileExists()) {
            $keys = $this->cacheFileManager->getContent();
            if (!in_array($key, Arr::get($keys, $this->group, []))) {
                $keys[$this->group][] = $key;
            }
        } else {
            $keys = [];
            $keys[$this->group][] = $key;
        }

        $this->cacheFileManager->writeContent($keys);

        return true;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function deleteCacheKey(string $key): bool
    {
        if ($this->cacheFileManager->fileExists()) {
            $keys = $this->cacheFileManager->getContent();
            if (!in_array($key, Arr::get($keys, $this->group, []))) {
                return false;
            } else {
                $keys[$this->group] = array_values(array_filter($keys[$this->group], fn($k) => $k != $key));
                $this->cacheFileManager->writeContent($keys);
                return true;
            }
        }
        return false;
    }
}
