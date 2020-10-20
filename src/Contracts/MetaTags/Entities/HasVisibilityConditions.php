<?php

namespace Butschster\Head\Contracts\MetaTags\Entities;

use Closure;

interface HasVisibilityConditions
{

    /**
     * Check if entity should be rendered
     *
     * @return bool
     */
    public function isVisible(): bool;

    /**
     * Add visibility condition
     * @param Closure $condition
     *
     * @return $this
     */
    public function visibleWhen(Closure $condition);
}
