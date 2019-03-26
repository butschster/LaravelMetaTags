<?php

namespace Butschster\Head\MetaTags;

use Illuminate\Contracts\Pagination\Paginator;
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
        return $this->addMeta('description', [
            'content' => $this->cleanString($description),
        ]);
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

        return $this->addMeta('keywords', [
            'content' => implode(', ', $keywords),
        ]);
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
        return $this->addMeta('robots', [
            'content' => $this->cleanString($behavior),
        ]);
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
        return $this->addMeta('content_type', [
            'http-equiv' => 'Content-Type',
            'content' => $this->cleanString($type . '; charset=' . $charset),
        ], false);
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
        return $this->addMeta('viewport', [
            'content' => $this->cleanString($viewport),
        ]);
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
        return $this->addLink('prev_href', [
            'rel' => 'prev',
            'href' => $this->cleanString($url)
        ]);
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
        return $this->addLink('next_href', [
            'rel' => 'next',
            'href' => $this->cleanString($url)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function setCanonical(string $url)
    {
        return $this->addLink('canonical', [
            'href' => $this->cleanString($url)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getCanonical(): ?Tag
    {
        return $this->getMeta('canonical');
    }

    /**
     * Set canonical link, prev and next from paginator object
     *
     * @param Paginator $paginator
     *
     * @return $this
     */
    public function setPaginationLinks(Paginator $paginator)
    {
        $this->setCanonical(
            $paginator->url($paginator->currentPage())
        );

        $this->setNextHref($paginator->nextPageUrl());
        $this->setPrevHref($paginator->previousPageUrl());

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
    public function addLink(string $name, array $attributes)
    {
        if (!isset($attributes['rel'])) {
            $attributes = array_merge(['rel' => $name], $attributes);
        }

        $this->metaTags->put($name, new Tag('link', $attributes, true));

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
     * @inheritdoc
     */
    public function reset(): void
    {
        $this->metaTags = new Collection();
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