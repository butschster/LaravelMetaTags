<?php

namespace Butschster\Head\MetaTags\Concerns;

use Butschster\Head\Contracts\MetaTags\PlacementInterface;
use Butschster\Head\MetaTags\PlacementsBag;

trait ManagePlacements
{
    /**
     * @var PlacementsBag
     */
    protected $placements;

    /**
     * @inheritdoc
     */
    public function head(): PlacementInterface
    {
        return $this->placement(static::PLACEMENT_HEAD);
    }

    /**
     * @inheritdoc
     */
    public function footer(): PlacementInterface
    {
        return $this->placement(static::PLACEMENT_FOOTER);
    }

    /**
     * @inheritdoc
     */
    public function placement(string $name): PlacementInterface
    {
        return $this->placements->getBag($name);
    }

    /**
     * @inheritdoc
     */
    public function getPlacements(): array
    {
        return $this->placements->all();
    }

    protected function initPlacements(): void
    {
        $this->placements = new PlacementsBag();
    }
}