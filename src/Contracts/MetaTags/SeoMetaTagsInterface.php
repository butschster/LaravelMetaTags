<?php

namespace Butschster\Head\Contracts\MetaTags;

interface SeoMetaTagsInterface
{
    /**
     * Get the meta title
     */
    public function getTitle(): ?string;

    /**
     * Get the meta description
     */
    public function getDescription(): ?string;

    /**
     * Get the meta keywords
     */
    public function getKeywords();
}
