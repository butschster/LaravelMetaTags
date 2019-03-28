<?php

namespace Butschster\Head\Packages;

use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\Contracts\Packages\PackageInterface;
use Butschster\Head\MetaTags\Meta;
use Butschster\Head\MetaTags\PlacementsBag;
use Butschster\Head\Packages\Concerns\Dependencies;

class Package extends Meta implements PackageInterface, MetaInterface
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
}