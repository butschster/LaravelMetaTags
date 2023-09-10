<?php

namespace Butschster\Head\Packages\Entities;

use Butschster\Head\Contracts\Packages\Entities\TwitterCardPackageInterface;

/**
 * @see https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/summary.html
 */
class TwitterCardPackage implements TwitterCardPackageInterface
{
    use Concerns\ManageMeta;

    public const CARD_SUMMARY = 'summary';
    
    public const CARD_SUMMARY_LARGE_IMAGE = 'summary_large_image';
    
    public const CARD_APP = 'app';
    
    public const CARD_PLAYER = 'player';
    
    protected string $prefix = 'twitter:';

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
     * Set the type of the card
     * The card type, which will be one of “summary”, “summary_large_image”, “app”, or “player”.
     */
    public function setType(string $type): self
    {
        return $this->addMeta('card', $type);
    }

    /**
     * Set the @username for the content creator / author.
     */
    public function setCreator(string $username): self
    {
        return $this->addMeta('creator', $username);
    }

    /**
     * Set the @username for the website used in the card footer.
     */
    public function setSite(string $site): self
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
     */
    public function setImage(string $url): self
    {
        return $this->addMeta('image', $url);
    }


    /**
     * Utility function for backwards compatibility
     *
     * @deprecated
     */
    public function addImage(string $url): self
    {
        return $this->setImage($url);
    }


    /**
     * Add a video URL
     *
     * @link https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/player-card
     */
    public function setVideo(string $url, array $properties = []): self
    {
        $this->addMeta('player', $url);

        foreach ($properties as $property => $content) {
            $this->addMeta('player:' . $property, $content);
        }

        return $this;
    }


    /**
     * Set the title
     */
    public function setTitle(string $title): self
    {
        return $this->addMeta('title', $title);
    }

    /**
     * Set the description
     *
     * A description that concisely summarizes the content as appropriate for presentation within a Tweet. You should
     * not re-use the title as the description or use this field to describe the general services provided by the website.
     */
    public function setDescription(string $description): self
    {
        return $this->addMeta('description', $description);
    }

    public function toArray(): array
    {
        return $this->tags->toArray();
    }
}
