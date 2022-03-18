<?php

namespace Kurneo\Support;

use Illuminate\Support\Arr;
use Throwable;

class Store implements Contracts\Store
{
    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @param string|array $key
     * @param null $value
     * @param bool $force
     * @return bool
     */
    public function set(string|array $key, $value = null, bool $force = false): bool
    {
        try {
            if (is_array($key)) {
                foreach ($key as $k => $v) {
                    Arr::set($this->data, $k, $v);
                }
            } else {
                Arr::set($this->data, $key, $value);
            }
            return true;
        } catch (Throwable $exception) {
            return false;
        }
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
