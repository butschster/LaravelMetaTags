<?php

namespace Butschster\Head\Packages;

use Butschster\Head\Contracts\Packages\PackageInterface;
use Butschster\Head\Contracts\WithDependencies;
use Butschster\Head\MetaTags\Meta;
use Butschster\Head\MetaTags\PlacementsBag;
use Butschster\Head\MetaTags\TagsCollection;
use Butschster\Head\Packages\Concerns\Dependencies;

class Package extends Meta implements PackageInterface, WithDependencies
{
    use Dependencies;

    public function __construct(
        protected string $name,
    ) {
        $this->placements = new PlacementsBag();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTags(): TagsCollection
    {
        return new TagsCollection();
    }
}
