<?php

namespace Kurneo\Support;

use Illuminate\Support\Arr;

class Store implements Contracts\Store
{
    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @param string|array $key
     * @param null $value
     * @return array
     */
    public function set(string|array $key, $value = null): array
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                Arr::set($this->data, $k, $v);
            }
        } else {
            Arr::set($this->data, $key, $value);
        }
        return $this->data;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get(string $key, $default = null): mixed
    {
        return Arr::get($this->data, $key, $default);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function forget(string $key): bool
    {
        if (!empty($key) && $this->has($key)) {
            Arr::forget($this->data, $key);
            return true;
        }
        return false;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return Arr::exists($this->data, $key);
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->data;
    }

    /**
     * @return bool
     */
    public function forgetAll(): bool
    {
        $this->data = [];
        return true;
    }
}
