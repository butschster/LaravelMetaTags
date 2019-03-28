<?php

namespace Butschster\Head\Contracts\Packages;

interface PackageInterface
{
    /**
     * Get the package name
     *
     * @return string
     */
    public function getName(): string;
}