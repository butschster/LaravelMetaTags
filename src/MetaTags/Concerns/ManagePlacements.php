<?php

namespace Butschster\Head\MetaTags\Concerns;

use Butschster\Head\Contracts\MetaTags\PlacementInterface;
use Butschster\Head\MetaTags\PlacementsBag;

trait ManagePlacements
{
    protected PlacementsBag $placements;

    public function head(): PlacementInterface
    {
        return $this->placement(static::PLACEMENT_HEAD);
    }

    public function footer(): PlacementInterface
    {
        return $this->placement(static::PLACEMENT_FOOTER);
    }

    public function placement(string $name): PlacementInterface
    {
        return $this->placements->getBag($name);
    }

    public function getPlacements(): array
    {
        return $this->placements->all();
    }

    protected function initPlacements(): void
    {
        $this->placements = new PlacementsBag();
    }
}
