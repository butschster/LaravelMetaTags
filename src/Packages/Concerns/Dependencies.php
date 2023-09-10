<?php

namespace Butschster\Head\Packages\Concerns;

trait Dependencies
{
    protected array $dependencies = [];

    public function requires(array|string $packages): self
    {
        $packages = is_array($packages) ? $packages : func_get_args();

        $this->dependencies = $packages;

        return $this;
    }

    public function getDependencies(): array
    {
        return array_unique($this->dependencies);
    }

    public function hasDependencies(): bool
    {
        return count($this->dependencies) > 0;
    }
}
