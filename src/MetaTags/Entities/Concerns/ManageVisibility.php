<?php

namespace Butschster\Head\MetaTags\Entities\Concerns;

use Closure;

trait ManageVisibility
{
    /**
     * Visibility condition
     * @var Closure
     */
    protected $visibilityCondition = null;

    /**
     * @inheritDoc
     */
    public function visibleWhen(Closure $condition)
    {
        $this->visibilityCondition = $condition;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isVisible(): bool
    {
        if ($this->visibilityCondition instanceof Closure) {
            return call_user_func($this->visibilityCondition);
        }

        return true;
    }
}
