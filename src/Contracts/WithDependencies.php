<?php

namespace Butschster\Head\Contracts;

interface WithDependencies
{
    /**
     * @return array
     */
    public function getDependencies(): array;

    /**
     * @return bool
     */
    public function hasDependencies();
}