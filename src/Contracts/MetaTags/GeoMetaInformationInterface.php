<?php

namespace Butschster\Head\Contracts\MetaTags;

interface GeoMetaInformationInterface
{
    /**
     * Get the latitude
     */
    public function latitude(): string;

    /**
     * Get the longitude
     */
    public function longitude(): string;

    /**
     * Get the Place Name
     */
    public function placename(): ?string;

    /**
     * Get the region
     */
    public function region(): ?string;
}
