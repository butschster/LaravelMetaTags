<?php

namespace Butschster\Head\Packages;

use Butschster\Head\MetaTags\MetaInterface;

interface PackageInterface extends MetaInterface
{
    /**
     * Get the package name
     *
     * @return string
     */
    public function getName(): string;
}