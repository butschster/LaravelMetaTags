<?php

namespace Butschster\Head\Packages\Entities;

use Butschster\Head\Contracts\Packages\PackageInterface;
use Butschster\Head\MetaTags\Entities\Tag;

/**
 * @see http://ogp.me/
 */
class OpenGraphPackage implements PackageInterface
{
    use Concerns\ManageMeta;
    protected string $prefix = 'og:';

    public function __construct(protected string $name)
    {
        $this->initTags();
    }

    /**
     * Get the package name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the type of your object, e.g., "video.movie". Depending on the type you specify, other properties may
     * also be required.
     */
    public function setType(string $type): self
    {
        return $this->addOgMeta('type', $type);
    }

    /**
     * Set the title of your object as it should appear within the graph, e.g., "The Rock".
     */
    public function setTitle(string $title): self
    {
        return $this->addOgMeta('title', $title);
    }

    /**
     * Set the description
     *
     * A one to two sentence description of your object.
     */
    public function setDescription(string $description): self
    {
        return $this->addOgMeta('description', $description);
    }

    /**
     * Set the site name
     * If your object is part of a larger web site, the name which should be displayed for the overall site. e.g., "IMDb".
     */
    public function setSiteName(string $name): self
    {
        return $this->addOgMeta('site_name', $name);
    }

    /**
     * Add an image URL which should represent your object within the graph.
     */
    public function addImage(string $url, array $properties = []): self
    {
        $this->addOgMeta('image', $url);

        foreach ($properties as $property => $content) {
            $this->addOgMeta('image:' . $property, $content);
        }

        return $this;
    }

    /**
     * Add a video URL
     */
    public function addVideo(string $url, array $properties = []): self
    {
        $this->addOgMeta('video', $url);

        foreach ($properties as $property => $content) {
            $this->addOgMeta('video:' . $property, $content);
        }

        return $this;
    }

    /**
     * Set the canonical URL of your object that will be used as its permanent ID in the graph.
     */
    public function setUrl(string $url): self
    {
        return $this->addOgMeta('url', $url);
    }

    /**
     * Set the locale these tags are marked up in. Of the format language_TERRITORY
     */
    public function setLocale(string $locale): self
    {
        return $this->addOgMeta('locale', $locale);
    }

    /**
     * Set other locales this page are available in.
     */
    public function addAlternateLocale(string ...$locales): self
    {
        foreach ($locales as $locale) {
            $key = $this->prefix . 'locale:alternate';

            $this->tags->put(
                $key . $locale,
                Tag::meta([
                    'property' => $key,
                    'content' => $locale,
                ]),
            );
        }

        return $this;
    }

    /**
     * Add custom meta tag
     */
    public function addOgMeta(string $key, string $content): self
    {
        $key = $this->prefix . $key;

        $this->tags->put(
            $key,
            Tag::meta([
                'property' => $key,
                'content' => $content,
            ]),
        );

        return $this;
    }

    public function toArray(): array
    {
        return $this->tags->toArray();
    }
}
