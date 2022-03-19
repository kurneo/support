<?php

namespace Kurneo\Support\Contracts;

interface Store
{
    /**
     * @return array
     */
    public function all(): array;

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get(string $key, $default = null): mixed;

    /**
     * @param string|array $key
     * @param null $value
     * @return mixed
     */
    public function set(string|array $key, $value = null): array;

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @param string $key
     * @return mixed
     */
    public function forget(string $key): bool;

    /**
     * @return bool
     */
    public function forgetAll(): bool;
}
