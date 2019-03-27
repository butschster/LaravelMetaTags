<?php

namespace Butschster\Head\MetaTags;

use Butschster\Head\Contracts\MetaTags\PlacementInterface;
use Illuminate\Support\Arr;

class PlacementsBag
{
    /**
     * The array of the view error bags.
     *
     * @var array
     */
    protected $bags = [];

    /**
     * Get a Placement instance from the bags.
     *
     * @param  string $key
     * @return PlacementInterface
     */
    public function getBag(string $key): PlacementInterface
    {
        return Arr::get($this->bags, $key) ?: $this->makeBug($key);
    }

    /**
     * Create a new Placement
     *
     * @param string $key
     *
     * @return Placement
     */
    public function makeBug(string $key)
    {
        return $this->bags[$key] = new Placement();
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->bags;
    }
}
