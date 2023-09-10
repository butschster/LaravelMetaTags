<?php

namespace Butschster\Head\Contracts\MetaTags\Entities;

use Closure;

interface HasVisibilityConditions
{

    /**
     * Check if entity should be rendered
     */
    public function isVisible(): bool;

    /**
     * Add visibility condition
     */
    public function visibleWhen(Closure $condition): self;
}
