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

    /**
     * @inheritdoc
     */
    public function setMetaFrom($object)
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

    /**
     * @inheritdoc
     */
    public function setDescription(?string $description, ?int $maxLength = null)
    {
        if (is_null($maxLength)) {
            $maxLength = $this->config('description.max_length');
        }

        return $this->addTag('description', new Description(
            $this->cleanString($description),
            $maxLength)
        );
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
    public function setKeywords($keywords, ?int $maxLength = null)
    {
        if (!is_array($keywords)) {
            $keywords = [$keywords];
        }

        if (is_null($maxLength)) {
            $maxLength = $this->config('keywords.max_length');
        }

        $keywords = array_map(function ($keyword) {
            return $this->cleanString($keyword);
        }, $keywords);

        return $this->addTag('keywords', new Keywords($keywords, $maxLength));
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
    public function setRobots(?string $behavior)
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
            'content' => function() {
                return Session::token();
            },
        ]);
    }

    /**
     * @inheritdoc
     */
    public function addWebmaster(string $service, string $content)
    {
        return $this->addTag('webmaster.'.$service, new Webmaster(
            $service, $content
        ));
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

        if ($region = $geo->region()) {
            $this->addMeta('geo.region', [
                'content' => $region,
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

        return $this->addTag($name, Tag::meta($attributes));
    }
}
