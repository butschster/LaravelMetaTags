<?php

namespace Butschster\Head\MetaTags\Entities\Concerns;

use Closure;

trait ManageVisibility
{
    /**
     * Visibility condition
     */
    protected ?Closure $visibilityCondition = null;

    public function visibleWhen(Closure $condition): self
    {
        $this->visibilityCondition = $condition;

        return $this;
    }

    public function isVisible(): bool
    {
        if ($this->visibilityCondition instanceof Closure) {
            return call_user_func($this->visibilityCondition);
        }

        return true;
    }
}
