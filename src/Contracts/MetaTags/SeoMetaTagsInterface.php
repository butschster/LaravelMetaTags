<?php

namespace Butschster\Head\Contracts\MetaTags;

interface SeoMetaTagsInterface
{
    /**
     * Get the meta title
     *
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * Get the meta description
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Get the meta keywords
     *
     * @return string|array|null
     */
    public function getKeywords();
}