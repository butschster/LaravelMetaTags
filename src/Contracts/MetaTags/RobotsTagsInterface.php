<?php

namespace Butschster\Head\Contracts\MetaTags;

interface RobotsTagsInterface
{
    /**
     * Get the meta robots
     *
     * @return string|null
     */
    public function getRobots(): ?string;
}