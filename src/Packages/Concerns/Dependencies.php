<?php

namespace Butschster\Head\Packages\Concerns;

trait Dependencies
{
    /**
     * @var array
     */
    protected $dependencies = [];

    /**
     * @param array|string $packages
     *
     * @return $this
     */
    public function requires($packages)
    {
        $packages = is_array($packages) ? $packages : func_get_args();

        $this->dependencies = (array) $packages;

        return $this;
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return array_unique($this->dependencies);
    }

    /**
     * @return bool
     */
    public function hasDependencies()
    {
        return count($this->dependencies) > 0;
    }
}