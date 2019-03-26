<?php

namespace Butschster\Head\MetaTags;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

class Meta implements MetaInterface
{
    /**
     * The collection of meta tags
     *
     * @var Collection
     */
    protected $metaTags;

    public function __construct()
    {
        $this->metaTags = new Collection();
        $this->metaTags->put('title', new Title());
    }

    /**
     * @inheritdoc
     */
    public function setTitle(string $title)
    {
        $this->metaTags->get('title')->setTitle(
            $this->cleanString($title)
        );

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setTitleSeparator(string $separator)
    {
        $this->getTitle()->setSeparator($separator);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function prependTitle(string $text)
    {
        $title = $this->getTitle();

        if ($title) {
            $title->prepend(
                $this->cleanString($text)
            );
        } else {
            $this->setTitle($text);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTitle(): ?Title
    {
        return $this->metaTags->get('title');
    }

    /**
     * @inheritdoc
     */
    public function setDescription(string $description)
    {
        $this->addMeta('description', [
            'content' => $this->cleanString($description),
        ]);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getDescription(): ?Tag
    {
        return $this->metaTags->get('description');
    }

    /**
     * @inheritdoc
     */
    public function setKeywords($keywords)
    {
        if (!is_array($keywords)) {
            $keywords = [$keywords];
        }

        $keywords = array_map(function ($keyword) {
            return $this->cleanString($keyword);
        }, $keywords);

        $this->addMeta('keywords', [
            'content' => implode(', ', $keywords),
        ]);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getKeywords(): ?Tag
    {
        return $this->getMeta('keywords');
    }

    /**
     * @inheritdoc
     */
    public function setRobots(string $behavior)
    {
        $this->addMeta('robots', [
            'content' => $this->cleanString($behavior),
        ]);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getRobots(): ?Tag
    {
        return $this->getMeta('robots');
    }

    /**
     * @inheritdoc
     */
    public function setContentType(string $type, string $charset = 'utf-8')
    {
        $this->addMeta('content_type', [
            'http-equiv' => 'Content-Type',
            'content' => $this->cleanString($type . '; charset=' . $charset),
        ], false);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getContentType(): ?Tag
    {
        return $this->getMeta('content_type');
    }


    /**
     * @inheritdoc
     */
    public function setViewport(string $viewport)
    {
        $this->addMeta('viewport', [
            'content' => $this->cleanString($viewport),
        ]);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getViewport(): ?Tag
    {
        return $this->getMeta('viewport');
    }

    /**
     * @inheritdoc
     */
    public function setPrevHref(string $url)
    {
        $this->metaTags->put(
            'prev_href',
            new Tag('link', [
                'rel' => 'prev',
                'href' => $this->cleanString($url)
            ], true)
        );

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPrevHref(): ?Tag
    {
        return $this->getMeta('prev_href');
    }

    /**
     * @inheritdoc
     */
    public function getNextHref(): ?Tag
    {
        return $this->getMeta('next_href');
    }

    /**
     * @inheritdoc
     */
    public function setNextHref(string $url)
    {
        $this->metaTags->put(
            'next_href',
            new Tag('link', [
                'rel' => 'next',
                'href' => $this->cleanString($url)
            ], true)
        );

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setGeo(GeoMetaInformationInterface $geo)
    {
        $this->addMeta('geo.position', [
            'content' => $this->cleanString($geo->latitude() . '; ' . $geo->longitude()),
        ]);

        if ($placename = $geo->placename()) {
            $this->addMeta('geo.placename', [
                'content' => $placename,
            ]);
        }

        if ($pregion = $geo->region()) {
            $this->addMeta('geo.region', [
                'content' => $pregion,
            ]);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addMeta(string $name, array $attributes, bool $checkNameAttribute = true)
    {
        if ($checkNameAttribute && !isset($attributes['name'])) {
            $attributes = array_merge(['name' => $name], $attributes);
        }

        $this->metaTags->put($name, new Tag('meta', $attributes));

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getMeta(string $name): ?Tag
    {
        return $this->metaTags->get($name);
    }

    /**
     * @inheritdoc
     */
    public function removeMeta(string $name): void
    {
        $this->metaTags->forget($name);
    }

    /**
     * Remove HTML tags
     * @param string $string
     * @return string
     */
    protected function cleanString(string $string): string
    {
        return e(strip_tags($string));
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->metaTags->map(function ($tag) {
            if ($tag instanceof Htmlable) {
                return $tag->toHtml();
            }

            return (string)$tag;
        })->implode(PHP_EOL);
    }
}