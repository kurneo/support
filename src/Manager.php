<?php declare(strict_types=1);

namespace Kurneo\Support;

use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Kurneo\Support\Exceptions\ManagerException;

abstract class Manager implements Contracts\Manager
{
    use Macroable;

    /**
     * Array of all drivers
     *
     * @var array
     */
    protected array $drivers = [];

    /**
     * @return array
     */
    public function getDrivers(): array
    {
        return $this->drivers;
    }

    /**
     * Get driver by name or resolve if not exist
     *
     * @param null $driver
     * @return mixed
     * @throws ManagerException
     */
    protected function getDriver($driver = null): mixed
    {

        $driver = $driver ?? $this->defaultDriver();

        if (is_null($driver)) {
            ManagerException::defaultDriverNotFound(static::class);
        }

        if (!isset($this->drivers[$driver])) {
            $this->drivers[$driver] = $this->createDriver($driver);
        }

        return $this->drivers[$driver];
    }

    /**
     * Create new driver instance
     *
     * @param $driver
     * @return mixed
     * @throws ManagerException
     */
    protected function createDriver($driver): mixed
    {
        $method = sprintf('create%sDriver', Str::studly($driver));

        if (method_exists($this, $method)) {
            return $this->$method();
        }

        ManagerException::creatorFunctionNotDefine($driver);
    }

    /**
     * Froward call to another driver
     *
     * @return array
     */
    protected function forwardToDriver(): array
    {
        return [];
    }

    /**
     *  Dynamic forward call to exist driver
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     * @throws ManagerException
     */
    public function __call($method, $parameters): mixed
    {
        $forwardTo = $this->forwardToDriver();
        if (isset($forwardTo[$method])) {
            return call_user_func_array([$this->getDriver($forwardTo[$method]), $method], $parameters);
        }
        return call_user_func_array([$this->getDriver(), $method], $parameters);
    }
}
