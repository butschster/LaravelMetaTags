<?php

namespace Butschster\Head\MetaTags;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Illuminate\Support\Collection;

class TagsCollection extends Collection
{
    /**
     * Set the item at a given offset.
     *
     * @param  mixed $key
     * @param  TagInterface $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if (!$value instanceof TagInterface) {
            throw new \InvalidArgumentException(
                'Tge tag nust implement of Butschster\Head\Contracts\MetaTags\Entities\TagInterface interface.'
            );
        }

        parent::offsetSet($key, $value);
    }
}