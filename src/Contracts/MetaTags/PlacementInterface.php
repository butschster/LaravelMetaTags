<?php

namespace Butschster\Head\Contracts\MetaTags;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

interface PlacementInterface extends Htmlable, Arrayable
{
    /**
     * Clear bag
     */
    public function reset(): void;
}
