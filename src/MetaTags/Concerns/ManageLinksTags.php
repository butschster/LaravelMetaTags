<?php

namespace Butschster\Head\MetaTags\Concerns;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\MetaTags\Entities\Favicon;
use Butschster\Head\MetaTags\Entities\Tag;
use Illuminate\Contracts\Pagination\Paginator;

trait ManageLinksTags
{
    public function setPrevHref(?string $url): self
    {
        if (!$url) {
            return $this;
        }

        return $this->addLink('prev_href', [
            'rel' => 'prev',
            'href' => strip_tags($url),
        ]);
    }

    public function getPrevHref(): ?TagInterface
    {
        return $this->getTag('prev_href');
    }

    public function setNextHref(?string $url): self
    {
        if (!$url) {
            return $this;
        }

        return $this->addLink('next_href', [
            'rel' => 'next',
            'href' => strip_tags($url),
        ]);
    }

    public function getNextHref(): ?TagInterface
    {
        return $this->getTag('next_href');
    }

    public function setCanonical(string $url): self
    {
        return $this->addLink('canonical', [
            'href' => strip_tags($url),
        ]);
    }

    public function getCanonical(): ?TagInterface
    {
        return $this->getTag('canonical');
    }

    public function setPaginationLinks(Paginator $paginator): self
    {
        $this->setCanonical($paginator->url($paginator->currentPage()));

        $this->setNextHref($paginator->nextPageUrl());
        $this->setPrevHref($paginator->previousPageUrl());

        return $this;
    }

    public function setHrefLang(string $lang, string $url): self
    {
        return $this->addLink('alternate_' . $lang, [
            'rel' => 'alternate',
            'hreflang' => $this->cleanString($lang),
            'href' => $this->cleanString($url),
        ]);
    }

    public function getHrefLang(string $lang): ?TagInterface
    {
        return $this->getTag('alternate_' . $lang);
    }

    public function setFavicon(string $href, array $attributes = []): self
    {
        return $this->addTag('favicon', new Favicon($href, $attributes));
    }

    public function addLink(string $name, array $attributes): self
    {
        if (!isset($attributes['rel'])) {
            $attributes = array_merge(['rel' => $name], $attributes);
        }

        return $this->addTag($name, Tag::link($attributes));
    }
}
