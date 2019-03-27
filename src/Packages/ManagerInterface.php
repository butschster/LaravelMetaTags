<?php

namespace Butschster\Head\Packages;

use Closure;

interface ManagerInterface
{
    /**
     * @param string $name
     * @param Closure $callback
     *
     * @return $this
     */
    public function register(string $name, Closure $callback);

    /**
     * Get all registered packages
     *
     * @return array
     */
    public function getPackages(): array;

    /**
     * Get registered package by name
     *
     * @param string $name
     *
     * @return Package|null
     */
    public function getPackage(string $name): ?Package;
}