<?php

namespace Butschster\Head\Packages\Entities\Concerns;

use Butschster\Head\MetaTags\Entities\Tag;
use Butschster\Head\MetaTags\TagsCollection;

trait ManageMeta
{
    /**
     * @var TagsCollection
     */
    protected $tags;

    protected function initTags(): void
    {
        $this->tags = new TagsCollection();
    }

    /**
     * Get the collection of tags
     *
     * @return TagsCollection
     */
    public function getTags(): TagsCollection
    {
        return $this->tags;
    }

    /**
     * Add custom meta tag
     *
     * @param string $key
     *
     * @param string $content
     *
     * @return $this
     */
    public function addMeta(string $key, string $content)
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
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->tags
            ->map(function ($tag) {
                return $tag->toHtml();
            })
            ->implode(PHP_EOL);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }
}