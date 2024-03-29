<?php

namespace Butschster\Head\Contracts\MetaTags;

interface RobotsTagsInterface
{
    /**
     * Get the meta robots
     */
    public function getRobots(): ?string;
}
