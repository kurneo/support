<?php declare(strict_types=1);

namespace Kurneo\Support;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;
use Kurneo\Support\Contracts\Hook as HookContract;
use Kurneo\Support\Exceptions\HookException;
use Kurneo\Support\Traits\Log;

abstract class Hook implements HookContract
{
    use Macroable, Log;

    /**
     * Array hook
     *
     * @var array
     */
    protected array $hooks = [];

    /**
     * @param string $name
     * @param $callback
     * @param int $priority
     * @param int $acceptedArgs
     * @return bool
     * @throws HookException
     */
    public function add(string $name, $callback, int $priority = 10, int $acceptedArgs = 1): bool
    {
        if ($priority < 1) {
            $backtrace = debug_backtrace()[0];
            $calledClass = @$backtrace['class'] . '@' . @$backtrace['function'];
            HookException::priorityInvalid($calledClass);
        }

        while (isset($this->hooks[$name][$priority])) {
            $priority++;
        }

        $this->hooks[$name][$priority] = compact('callback', 'acceptedArgs');

        ksort($this->hooks[$name]);

        return true;
    }

    /**
     * Remove one hook
     *
     * @param string $name
     * @return bool
     */
    public function remove(string $name): bool
    {
        if (!Arr::has($this->hooks, $name)) return false;
        Arr::forget($this->hooks, $name);
        return true;
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function get(string $name): array|null
    {
        return Arr::get($this->hooks, $name);
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->hooks;
    }

    /**
     * @param mixed $callback
     * @return array|Closure|false|string
     */
    protected function resolveCallBack(string|array|Closure $callback): array|Closure|false|string
    {
        if (is_string($callback)) {
            if (strpos($callback, '@')) {
                $callback = explode('@', $callback);
                return [$callback[0], $callback[1]];
            }
            return $callback;
        } else if ($callback instanceof Closure || is_array($callback) && count($callback) == 2) {
            return $callback;
        } else {
            return false;
        }
    }
}
