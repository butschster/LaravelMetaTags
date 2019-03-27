<?php

namespace Butschster\Head\Packages;

use Closure;
use Illuminate\Support\Collection;

class Manager implements ManagerInterface
{
    /**
     * @var Collection
     */
    protected $packages;

    public function __construct()
    {
        $this->packages = new Collection();
    }

    /**
     * @param string $name
     * @param Closure $callback
     *
     * @return $this
     */
    public function register(string $name, Closure $callback = null)
    {
        $this->packages->put($name, $package = new Package($name));

        if ($callback) {
            $callback->__invoke($package);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getPackages(): array
    {
        return $this->packages->all();
    }

    /**
     * Get registered package by name
     *
     * @param string $name
     *
     * @return Package|null
     */
    public function getPackage(string $name): ?Package
    {
        return $this->packages->get($name);
    }
}