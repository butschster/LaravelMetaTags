<?php

namespace Butschster\Head\Contracts\MetaTags\Entities;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

interface TagInterface extends Htmlable, Arrayable
{
    /**
     * Get tag placement (footer, head, ...)
     */
    public function getPlacement(): string;
}
