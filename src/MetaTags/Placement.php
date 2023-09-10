<?php

namespace Butschster\Head\MetaTags;

use Butschster\Head\Contracts\MetaTags\PlacementInterface;
use Illuminate\Contracts\Support\Htmlable;

class Placement extends TagsCollection implements PlacementInterface, \Stringable
{
    /**
     * Clear bag
     */
    public function reset(): void
    {
        $this->items = [];
    }

    /**
     * Get content as a string of HTML.
     */
    public function toHtml(): string
    {
        return $this
            ->onlyVisible()
            ->stringifyEntities()
            ->implode(PHP_EOL);
    }

    public function __toString(): string
    {
        return $this->toHtml();
    }
}
