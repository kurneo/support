<?php declare(strict_types=1);

namespace Kurneo\Support\Contracts;

interface Hook
{
    /**
     * Add Hook
     *
     * @param string $name
     * @param $callback
     * @param int $priority
     * @param int $acceptedArgs
     * @return bool
     */
    public function add(string $name, $callback, int $priority = 10, int $acceptedArgs = 1): bool;

    /**
     * Remove one Hook
     *
     * @param string $name
     * @return bool
     */
    public function remove(string $name): bool;

    /**
     * Get hook
     *
     * @param string $name
     * @return array|null
     */
    public function get(string $name): array|null;

    /**
     * @return array
     */
    public function all(): array;

    /**
     * Fire a hook!
     *
     * @param string $name
     * @param ...$args
     */
    public function fire(string $name, ...$args);
}
