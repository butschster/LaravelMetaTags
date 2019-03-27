<?php

namespace Butschster\Head\MetaTags;

use Butschster\Head\Contracts\MetaTags\PlacementInterface;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

class Placement extends Collection implements PlacementInterface
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
        return $this->map(function ($tag) {
            if ($tag instanceof Htmlable) {
                return $tag->toHtml();
            }

            return (string) $tag;
        })->implode(PHP_EOL);
    }
}