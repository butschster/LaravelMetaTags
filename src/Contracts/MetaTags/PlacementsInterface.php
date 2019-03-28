<?php

namespace Butschster\Head\Contracts\MetaTags;

interface PlacementsInterface
{
    /**
     * Get specific placement by name
     *
     * @param string $name
     *
     * @return PlacementInterface
     */
    public function placement(string $name): PlacementInterface;

    /**
     * Get all registered placements
     *
     * @return array
     */
    public function getPlacements(): array;

}