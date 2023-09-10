<?php

namespace Butschster\Head\MetaTags;

use Butschster\Head\Contracts\MetaTags\Entities\HasVisibilityConditions;
use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

/**
 * @template T of TagInterface
 */
class TagsCollection extends Collection
{
    /**
     * Filter only visible tags
     */
    public function onlyVisible(): self
    {
        return $this->filter(static function (TagInterface $tag) {
            if ($tag instanceof HasVisibilityConditions) {
                return $tag->isVisible();
            }
            return true;
        });
    }

    /**
     * Convert to string entities
     */
    public function stringifyEntities(): self
    {
        return $this->map(static function ($tag) {
            if ($tag instanceof Htmlable) {
                return $tag->toHtml();
            }
            return (string)$tag;
        });
    }

    /**
     * Set the item at a given offset.
     *
     * @param TagInterface $value
     */
    public function offsetSet(mixed $key, mixed $value): void
    {
        if (!$value instanceof TagInterface) {
            throw new \InvalidArgumentException(
                'The tag must implement of Butschster\Head\Contracts\MetaTags\Entities\TagInterface interface.',
            );
        }

        parent::offsetSet($key, $value);
    }

    public function toArray(): array
    {
        return array_values(parent::toArray());
    }
}
