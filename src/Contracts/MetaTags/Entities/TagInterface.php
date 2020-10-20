<?php

namespace Butschster\Head\Contracts\MetaTags\Entities;

use Illuminate\Contracts\Support\Htmlable;

interface TagInterface extends Htmlable
{
    /**
     * Get tag placement (footer, head, ...)
     * @return string
     */
    public function getPlacement(): string;
}
