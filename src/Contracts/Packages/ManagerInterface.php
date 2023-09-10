<?php

namespace Butschster\Head\Contracts\Packages;

use Closure;

interface ManagerInterface
{
    /**
     * Create a new package
     */
    public function create(string $name, Closure $callback): self;

    /**
     * Register the package
     */
    public function register(PackageInterface $package): self;

    /**
     * Get all registered packages
     */
    public function getPackages(): array;

    /**
     * Get registered package by name
     */
    public function getPackage(string $name): ?PackageInterface;
}
