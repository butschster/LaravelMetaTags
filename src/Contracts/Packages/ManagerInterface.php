<?php

namespace Butschster\Head\Contracts\Packages;

use Closure;

interface ManagerInterface
{
    /**
     * Create a new package
     *
     * @param string $name
     * @param Closure $callback
     *
     * @return $this
     */
    public function create(string $name, Closure $callback);

    /**
     * Register the package
     *
     * @param PackageInterface $package
     *
     * @return $this
     */
    public function register(PackageInterface $package);

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
     * @return PackageInterface|null
     */
    public function getPackage(string $name): ?PackageInterface;
}