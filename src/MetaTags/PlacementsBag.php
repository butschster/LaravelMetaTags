<?php

namespace Butschster\Head\MetaTags;

use Butschster\Head\Contracts\MetaTags\PlacementInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class PlacementsBag implements Arrayable
{
    /**
     * The array of the view error bags.
     */
    protected array $bags = [];

    /**
     * Get a Placement instance from the bags.
     */
    public function getBag(string $key): PlacementInterface
    {
        return Arr::get($this->bags, $key) ?: $this->makeBug($key);
    }

    /**
     * Create a new Placement
     */
    public function makeBug(string $key): PlacementInterface
    {
        return $this->bags[$key] = new Placement();
    }

    public function all(): array
    {
        return $this->bags;
    }

    public function toArray(): array
    {
        return array_map(static fn(Placement $placement) => $placement->toArray(), $this->bags);
    }
}
