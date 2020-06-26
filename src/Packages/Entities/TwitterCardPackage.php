<?php

namespace Butschster\Head\Packages\Entities;

use Butschster\Head\Contracts\Packages\Entities\TwitterCardPackageInterface;

/**
 * @see https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/summary.html
 */
class TwitterCardPackage implements TwitterCardPackageInterface
{
    use Concerns\ManageMeta;

    const CARD_SUMMARY = 'summary';
    const CARD_SUMMARY_LARGE_IMAGE = 'summary_large_image';
    const CARD_APP = 'app';
    const CARD_PLAYER = 'player';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $prefix = 'twitter:';

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
     * Set the type of the card
     * The card type, which will be one of “summary”, “summary_large_image”, “app”, or “player”.
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type)
    {
        return $this->addMeta('card', $type);
    }

    /**
     * Set the @username for the content creator / author.
     *
     * @param string $username
     *
     * @return $this
     */
    public function setCreator(string $username)
    {
        return $this->addMeta('creator', $username);
    }

    /**
     * Set the @username for the website used in the card footer.
     *
     * @param string $site
     *
     * @return $this
     */
    public function setSite(string $site)
    {
        return $this->addMeta('site', $site);
    }

    /**
     * Add the image representing the content of the page.
     *
     * A URL to a unique image representing the content of the page. You should not use a generic image such as your
     * website logo, author photo, or other image that spans multiple pages. Images for this Card support an aspect
     * ratio of 1:1 with minimum dimensions of 144x144 or maximum of 4096x4096 pixels. Images must be less than 5MB
     * in size. The image will be cropped to a square on all platforms. JPG, PNG, WEBP and GIF formats are supported.
     * Only the first frame of an animated GIF will be used. SVG is not supported.
     *
     * @link https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/summary
     * @link https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/summary-card-with-large-image
     *
     * @param string $url
     *
     * @return $this
     */
    public function setImage(string $url)
    {
        return $this->addMeta('image', $url);
    }


    /**
     * Utility function for backwards compatibility
     *
     * @deprecated
     */
    public function addImage(string $url)
    {
        return $this->setImage($url);
    }


    /**
     * Add a video URL
     *
     * @link https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/player-card
     *
     * @param string $url
     * @param array  $properties
     *
     * @return $this
     */
    public function setVideo(string $url, array $properties = [])
    {
        $this->addMeta('player', $url);

        foreach ($properties as $property => $content) {
            $this->addMeta('player:' . $property, $content);
        }

        return $this;
    }


    /**
     * Set the title
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
     * A description that concisely summarizes the content as appropriate for presentation within a Tweet. You should
     * not re-use the title as the description or use this field to describe the general services provided by the website.
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription(string $description)
    {
        return $this->addMeta('description', $description);
    }
}
