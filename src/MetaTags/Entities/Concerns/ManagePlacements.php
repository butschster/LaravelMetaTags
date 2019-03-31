<?php

namespace Butschster\Head\MetaTags\Entities\Concerns;

use Butschster\Head\MetaTags\Meta;

trait ManagePlacements
{
    /**
     * @var string
     */
    protected $placement = Meta::PLACEMENT_HEAD;


    /**
     * @return string
     */
    public function getPlacement(): string
    {
        return $this->placement;
    }

    /**
     * @param string $placement
     *
     * @return $this
     */
    public function setPlacement(string $placement)
    {
        $this->placement = $placement;

        return $this;
    }

}