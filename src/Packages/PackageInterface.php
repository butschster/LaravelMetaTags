<?php

namespace Butschster\Head\Packages;

use Butschster\Head\MetaTags\Meta;
use Butschster\Head\MetaTags\MetaInterface;

interface PackageInterface extends MetaInterface
{
    /**
     * Get the package name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set a link to css file
     *
     * @param string $name
     * @param string $src
     * @param array $attributes
     * @param array $dependency Required packages
     *
     * @return $this
     */
    public function addStyle(string $name, string $src, array $attributes = [], array $dependency = []);


    /**
     * Set a link to script file
     *
     * @param string $name
     * @param string $src
     * @param array $attributes
     * @param array $dependency Required packages
     * @param string $placement
     *
     * @return $this
     */
    public function addScript(string $name, string $src, array $attributes = [], array $dependency = [], string $placement = Meta::PLACEMENT_FOOTER);
}