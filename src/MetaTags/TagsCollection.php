<?php

namespace Butschster\Head\MetaTags;

use Butschster\Head\Contracts\MetaTags\Entities\HasVisibilityConditions;
use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

class TagsCollection extends Collection
{
    /**
     * Filter only visible tags
     * @return TagsCollection
     */
    public function onlyVisible()
    {
        return $this->filter(function (TagInterface $tag) {
            if ($tag instanceof HasVisibilityConditions) {
                return $tag->isVisible();
            }

            return true;
        });
    }

    /**
     * Convert to string entities
     * @return TagsCollection
     */
    public function stringifyEntities()
    {
        return $this->map(function ($tag) {
            if ($tag instanceof Htmlable) {
                return $tag->toHtml();
            }

            return (string)$tag;
        });
    }

    /**
     * Set the item at a given offset.
     *
     * @param mixed $key
     * @param TagInterface $value
     * @return void
     */
    public function offsetSet($key, $value): void
    {
        if (!$value instanceof TagInterface) {
            throw new \InvalidArgumentException(
                'Tge tag nust implement of Butschster\Head\Contracts\MetaTags\Entities\TagInterface interface.'
            );
        }

        parent::offsetSet($key, $value);
    }

    public function toArray()
    {
        return array_values(parent::toArray());
    }
}
