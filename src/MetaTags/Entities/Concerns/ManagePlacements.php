<?php

namespace Butschster\Head\MetaTags\Entities\Concerns;

use Butschster\Head\MetaTags\Meta;

trait ManagePlacements
{
    protected string $placement = Meta::PLACEMENT_HEAD;

    public function getPlacement(): string
    {
        return $this->placement;
    }

    public function setPlacement(string $placement): self
    {
        $this->placement = $placement;

        return $this;
    }

}
