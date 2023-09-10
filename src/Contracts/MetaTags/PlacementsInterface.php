<?php

namespace Butschster\Head\Contracts\MetaTags;

interface PlacementsInterface
{
    /**
     * Get specific placement by name
     */
    public function placement(string $name): PlacementInterface;

    /**
     * Get all registered placements
     */
    public function getPlacements(): array;

}
