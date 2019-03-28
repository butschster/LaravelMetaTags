<?php

namespace Butschster\Head\MetaTags\Concerns;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\Contracts\MetaTags\GeoMetaInformationInterface;
use Butschster\Head\MetaTags\Entities\Tag;
use Illuminate\Support\Facades\Session;

trait ManageMetaTags
{
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
    public function getDescription(): ?TagInterface
    {
        return $this->getTag('description');
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
    public function getKeywords(): ?TagInterface
    {
        return $this->getTag('keywords');
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
    public function getRobots(): ?TagInterface
    {
        return $this->getTag('robots');
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
    public function getContentType(): ?TagInterface
    {
        return $this->getTag('content_type');
    }

    /**
     * @inheritdoc
     */
    public function setCharset(string $charset = 'utf-8')
    {
        return $this->addMeta('charset', [
            'charset' => $charset,
        ], false);
    }

    /**
     * @inheritdoc
     */
    public function getCharset(): ?TagInterface
    {
        return $this->getTag('charset');
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
    public function getViewport(): ?TagInterface
    {
        return $this->getTag('viewport');
    }

    /**
     * @inheritdoc
     */
    public function addCsrfToken()
    {
        return $this->addMeta('csrf-token', [
            'content' => Session::token(),
        ]);
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

        return $this->addTag($name, new Tag('meta', $attributes));
    }
}