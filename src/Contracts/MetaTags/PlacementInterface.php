<?php

namespace Butschster\Head\Contracts\MetaTags;

use Illuminate\Contracts\Support\Htmlable;

interface PlacementInterface extends Htmlable
{
    /**
     * Clear bag
     */
    public function reset(): void;
}