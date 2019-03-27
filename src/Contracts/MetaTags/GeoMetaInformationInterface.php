<?php

namespace Butschster\Head\Contracts\MetaTags;

interface GeoMetaInformationInterface
{
    /**
     * Get the latitude
     * 
     * @return string
     */
    public function latitude(): string;

    /**
     * Get the longitude
     * 
     * @return string
     */
    public function longitude(): string;

    /**
     * Get the Place Name
     *
     * @return string|null
     */
    public function placename(): ?string;

    /**
     * Get the region
     *
     * @return string|null
     */
    public function region(): ?string;
}