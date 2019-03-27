<?php

namespace Butschster\Head\Packages;

use Butschster\Head\MetaTags\Meta;
use Butschster\Head\MetaTags\PlacementsBag;
use Butschster\Head\Packages\Concerns\Dependencies;

class Package extends Meta implements PackageInterface
{
    use Dependencies;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->placements = new PlacementsBag();
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function addStyle(string $name, string $src, array $attributes = [], array $dependency = [])
    {
        $this->addTag(
            $name,
            new Style($name, $src, $attributes, $dependency)
        );

        return $this;
    }

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
    public function addScript(string $name, string $src, array $attributes = [], array $dependency = [], string $placement = Meta::PLACEMENT_FOOTER)
    {
        $this->addTag(
            $name,
            new Script($name, $src, $attributes, $dependency, $placement)
        );

        return $this;
    }
}