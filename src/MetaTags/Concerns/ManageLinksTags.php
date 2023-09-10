<?php

namespace Butschster\Head\MetaTags\Concerns;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\MetaTags\Entities\Favicon;
use Butschster\Head\MetaTags\Entities\Tag;
use Illuminate\Contracts\Pagination\Paginator;

trait ManageLinksTags
{
    /**
     * @inheritdoc
     */
    public function setPrevHref(?string $url)
    {
        if (!$url) {
            return $this;
        }

        return $this->addLink('prev_href', [
            'rel' => 'prev',
            'href' => strip_tags($url),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getPrevHref(): ?TagInterface
    {
        return $this->getTag('prev_href');
    }

    /**
     * @inheritdoc
     */
    public function setNextHref(?string $url)
    {
        if (!$url) {
            return $this;
        }

        return $this->addLink('next_href', [
            'rel' => 'next',
            'href' => strip_tags($url),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getNextHref(): ?TagInterface
    {
        return $this->getTag('next_href');
    }

    /**
     * @inheritdoc
     */
    public function setCanonical(string $url)
    {
        return $this->addLink('canonical', [
            'href' => strip_tags($url),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getCanonical(): ?TagInterface
    {
        return $this->getTag('canonical');
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
        $this->setCanonical($paginator->url($paginator->currentPage()));

        $this->setNextHref($paginator->nextPageUrl());
        $this->setPrevHref($paginator->previousPageUrl());

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setHrefLang(string $lang, string $url)
    {
        return $this->addLink('alternate_' . $lang, [
            'rel' => 'alternate',
            'hreflang' => $this->cleanString($lang),
            'href' => $url,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getHrefLang(string $lang): ?TagInterface
    {
        return $this->getTag('alternate_' . $lang);
    }

    /**
     * @inheritdoc
     */
    public function setFavicon(string $href, array $attributes = [])
    {
        return $this->addTag('favicon', new Favicon($href, $attributes));
    }

    /**
     * @inheritdoc
     */
    public function addLink(string $name, array $attributes)
    {
        if (!isset($attributes['rel'])) {
            $attributes = array_merge(['rel' => $name], $attributes);
        }

        return $this->addTag($name, Tag::link($attributes));
    }
}
