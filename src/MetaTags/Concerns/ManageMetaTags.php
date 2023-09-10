<?php

namespace Butschster\Head\MetaTags\Concerns;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\Contracts\MetaTags\GeoMetaInformationInterface;
use Butschster\Head\Contracts\MetaTags\RobotsTagsInterface;
use Butschster\Head\Contracts\MetaTags\SeoMetaTagsInterface;
use Butschster\Head\MetaTags\Entities\Description;
use Butschster\Head\MetaTags\Entities\Keywords;
use Butschster\Head\MetaTags\Entities\Tag;
use Butschster\Head\MetaTags\Entities\Webmaster;
use Illuminate\Support\Facades\Session;

trait ManageMetaTags
{
    public function setMetaFrom($object): self
    {
        if ($object instanceof SeoMetaTagsInterface) {
            $this->setTitle($object->getTitle())
                ->setDescription($object->getDescription())
                ->setKeywords($object->getKeywords());
        }

        if ($object instanceof RobotsTagsInterface) {
            $this->setRobots($object->getRobots());
        }

        if ($object instanceof GeoMetaInformationInterface) {
            $this->setGeo($object);
        }

        return $this;
    }

    public function setDescription(?string $description, ?int $maxLength = null): self
    {
        if (is_null($maxLength)) {
            $maxLength = $this->config('description.max_length');
        }

        return $this->addTag('description', new Description(
            $this->cleanString($description),
            $maxLength)
        );
    }

    public function getDescription(): ?TagInterface
    {
        return $this->getTag('description');
    }

    public function setKeywords($keywords, ?int $maxLength = null): self
    {
        if (!is_array($keywords)) {
            $keywords = [$keywords];
        }

        if (is_null($maxLength)) {
            $maxLength = $this->config('keywords.max_length');
        }

        $keywords = array_map(fn($keyword) => $this->cleanString($keyword), $keywords);

        return $this->addTag('keywords', new Keywords($keywords, $maxLength));
    }

    public function getKeywords(): ?TagInterface
    {
        return $this->getTag('keywords');
    }

    public function setRobots(?string $behavior): self
    {
        return $this->addMeta('robots', [
            'content' => $this->cleanString($behavior),
        ]);
    }

    public function getRobots(): ?TagInterface
    {
        return $this->getTag('robots');
    }

    public function setContentType(string $type, string $charset = 'utf-8'): self
    {
        return $this->addMeta('content_type', [
            'http-equiv' => 'Content-Type',
            'content' => $this->cleanString($type . '; charset=' . $charset),
        ], false);
    }

    public function getContentType(): ?TagInterface
    {
        return $this->getTag('content_type');
    }

    public function setCharset(string $charset = 'utf-8'): self
    {
        return $this->addMeta('charset', [
            'charset' => $charset,
        ], false);
    }

    public function getCharset(): ?TagInterface
    {
        return $this->getTag('charset');
    }

    public function setViewport(string $viewport): self
    {
        return $this->addMeta('viewport', [
            'content' => $this->cleanString($viewport),
        ]);
    }

    public function getViewport(): ?TagInterface
    {
        return $this->getTag('viewport');
    }

    public function addCsrfToken(): self
    {
        return $this->addMeta('csrf-token', [
            'content' => static fn() => Session::token(),
        ]);
    }

    public function addWebmaster(string $service, string $content): self
    {
        return $this->addTag('webmaster.'.$service, new Webmaster(
            $service, $content
        ));
    }

    public function setGeo(GeoMetaInformationInterface $geo): self
    {
        $this->addMeta('geo.position', [
            'content' => $this->cleanString($geo->latitude() . '; ' . $geo->longitude()),
        ]);

        if ($placename = $geo->placename()) {
            $this->addMeta('geo.placename', [
                'content' => $placename,
            ]);
        }

        if ($region = $geo->region()) {
            $this->addMeta('geo.region', [
                'content' => $region,
            ]);
        }

        return $this;
    }

    public function addMeta(string $name, array $attributes, bool $checkNameAttribute = true): self
    {
        if ($checkNameAttribute && !isset($attributes['name'])) {
            $attributes = array_merge(['name' => $name], $attributes);
        }

        return $this->addTag($name, Tag::meta($attributes));
    }
}
