<?php

namespace Butschster\Head\Packages\Entities;

use Butschster\Head\Contracts\Packages\PackageInterface;
use Butschster\Head\MetaTags\Entities\Tag;
use Butschster\Head\Packages\Entities\Concerns\ManageMeta;

/**
 * @see http://ogp.me/
 */
class OpenGraphPackage implements PackageInterface
{
    use Concerns\ManageMeta;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $prefix = 'og:';

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->initTags();
    }

    /**
     * Get the package name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the type of your object, e.g., "video.movie". Depending on the type you specify, other properties may
     * also be required.
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type)
    {
        return $this->addOgMeta('type', $type);
    }

    /**
     * Set the title of your object as it should appear within the graph, e.g., "The Rock".
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title)
    {
        return $this->addOgMeta('title', $title);
    }

    /**
     * Set the description
     *
     * A one to two sentence description of your object.
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription(string $description)
    {
        return $this->addOgMeta('description', $description);
    }

    /**
     * Set the site name
     * If your object is part of a larger web site, the name which should be displayed for the overall site. e.g., "IMDb".
     *
     * @param string $name
     *
     * @return $this
     */
    public function setSiteName(string $name)
    {
        return $this->addOgMeta('site_name', $name);
    }

    /**
     * Add an image URL which should represent your object within the graph.
     *
     * @param string $url
     * @param array $properties
     *
     * @return $this
     */
    public function addImage(string $url, array $properties = [])
    {
        $this->addOgMeta('image', $url);

        foreach ($properties as $property => $content) {
            $this->addOgMeta('image:' . $property, $content);
        }

        return $this;
    }

    /**
     * Add an video URL
     *
     * @param string $url
     * @param array $properties
     *
     * @return $this
     */
    public function addVideo(string $url, array $properties = [])
    {
        $this->addOgMeta('video', $url);

        foreach ($properties as $property => $content) {
            $this->addOgMeta('video:' . $property, $content);
        }

        return $this;
    }

    /**
     * Set the canonical URL of your object that will be used as its permanent ID in the graph.
     *
     * @param string $url
     *
     * @return $this
     */
    public function setUrl(string $url)
    {
        return $this->addOgMeta('url', $url);
    }

    /**
     * Set the locale these tags are marked up in. Of the format language_TERRITORY
     *
     * @param string $locale
     *
     * @return $this
     */
    public function setLocale(string $locale)
    {
        return $this->addOgMeta('locale', $locale);
    }

    /**
     * Set other locales this page are available in.
     *
     * @param string[] $locales
     *
     * @return $this
     */
    public function addAlternateLocale(string ...$locales)
    {
        foreach ($locales as $locale) {
            $key = $this->prefix . 'locale:alternate';

            $this->tags->put($key . $locale, Tag::meta([
                'property' => $key,
                'content' => $locale,
            ]));
        }

        return $this;
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
    public function addOgMeta(string $key, string $content)
    {
        $key = $this->prefix.$key;

        $this->tags->put($key, Tag::meta([
            'property' => $key,
            'content' => $content,
        ]));

        return $this;
    }

    public function toArray()
    {
        return  $this->tags->toArray();
    }
}
