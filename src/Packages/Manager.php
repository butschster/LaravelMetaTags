<?php

namespace Butschster\Head\Packages;

use Butschster\Head\Contracts\Packages\ManagerInterface;
use Butschster\Head\Contracts\Packages\PackageInterface;
use Closure;
use Illuminate\Support\Collection;

class Manager implements ManagerInterface
{
    protected Collection $packages;

    public function __construct()
    {
        $this->packages = new Collection();
    }

    public function register(PackageInterface $package): self
    {
        $this->packages->put($package->getName(), $package);

        return $this;
    }

    public function create(string $name, Closure $callback = null): self
    {
        $this->register($package = new Package($name));

        if ($callback !== null) {
            $callback->__invoke($package);
        }

        return $this;
    }

    public function getPackages(): array
    {
        return $this->packages->all();
    }

    public function getPackage(string $name): ?PackageInterface
    {
        return $this->packages->get($name);
    }
}
