<?php

namespace Butschster\Head\Packages\Entities\Concerns;

use Butschster\Head\MetaTags\Entities\Tag;
use Butschster\Head\MetaTags\TagsCollection;

trait ManageMeta
{
    protected TagsCollection $tags;

    protected function initTags(): void
    {
        $this->tags = new TagsCollection();
    }

    /**
     * Get the collection of tags
     */
    public function getTags(): TagsCollection
    {
        return $this->tags;
    }

    /**
     * Add custom meta tag
     */
    public function addMeta(string $key, string $content): self
    {
        $key = $this->prefix.$key;

        $this->tags->put($key, Tag::meta([
            'name' => $key,
            'content' => $content,
        ]));

        return $this;
    }

    /**
     * Get content as a string of HTML.
     */
    public function toHtml(): string
    {
        return $this->tags
            ->map(static fn($tag) => $tag->toHtml())
            ->implode(PHP_EOL);
    }

    public function __toString(): string
    {
        return $this->toHtml();
    }
}
