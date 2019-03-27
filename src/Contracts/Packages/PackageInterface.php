<?php

namespace Butschster\Head\Contracts\Packages;

use Butschster\Head\Contracts\MetaTags\MetaInterface;

interface PackageInterface extends MetaInterface
{
    /**
     * Get the package name
     *
     * @return string
     */
    public function getName(): string;
}