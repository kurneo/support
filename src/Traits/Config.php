<?php declare(strict_types=1);

namespace Kurneo\Support;

use Illuminate\Support\Arr;

trait Config
{
    /**
     * @var string
     */
    protected string $configPath = '';

    /**
     * @var array
     */
    protected array $configs = [];

    /**
     * @var bool
     */
    protected bool $configLoaded = false;

    /**
     * @param string $path
     * @return $this
     */
    public function setConfigPath(string $path = ''): static
    {
        $this->configPath = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getConfigPath(): string
    {
        return $this->configPath;
    }

    /**
     * @param string|null $key
     * @param null $default
     * @param bool $reload
     * @return mixed
     */
    public function getConfig(string|null $key = null, $default = null, bool $reload = false): mixed
    {
        if ($reload || !$this->configLoaded) {
            $this->configs = config($this->getConfigPath()) ?? [];
            $this->configLoaded = true;
        }

        if (!$key) return $this->configs;

        return Arr::get($this->configs, $key, $default);
    }

    /**
     * @param string $key
     * @param mixed|null $value
     * @param bool $write
     * @return $this
     */
    public function setConfig(string $key, mixed $value = null, bool $write = true): static
    {
        Arr::set($this->configs, $key, $value);
        if ($write) {
            $configPath = implode('.', [$this->configPath, $key]);
            config()->set($configPath, $value);
        }
        return $this;
    }
}
