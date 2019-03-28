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
        return $this->addMeta('type', $type);
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
        return $this->addMeta('title', $title);
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
        return $this->addMeta('description', $description);
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
        return $this->addMeta('site_name', $name);
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
        $this->addMeta('image', $url);

        foreach ($properties as $property => $content) {
            $this->addMeta('image:' . $property, $content);
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
        $this->addMeta('video', $url);

        foreach ($properties as $property => $content) {
            $this->addMeta('video:' . $property, $content);
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
        return $this->addMeta('url', $url);
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
        return $this->addMeta('locale', $locale);
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

            $this->tags->put($key . $locale, new Tag('meta', [
                'name' => $key,
                'content' => $locale,
            ]));
        }

        return $this;
    }
}