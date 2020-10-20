<?php

namespace Butschster\Head\MetaTags;

use Butschster\Head\Contracts\MetaTags\PlacementInterface;
use Illuminate\Contracts\Support\Htmlable;

class Placement extends TagsCollection implements PlacementInterface
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
     * @return string
     */
    public function toHtml()
    {
        return $this
            ->onlyVisible()
            ->stringifyEntities()
            ->implode(PHP_EOL);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }
}
