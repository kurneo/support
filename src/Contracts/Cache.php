<?php declare(strict_types=1);

namespace Kurneo\Support\Contracts;

interface Cache
{
    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed;

    /**
     * @param string $key
     * @param mixed $value
     * @param int|false $ttl
     * @return bool
     */
    public function put(string $key, mixed $value, int|false $ttl = false): bool;

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @param string $key
     * @return bool
     */
    public function delete(string $key): bool;

    /**
     * @return bool
     */
    public function flush(): bool;
}
