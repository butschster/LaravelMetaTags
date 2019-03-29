<?php

namespace Butschster\Head\MetaTags;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\Packages\Manager;
use Illuminate\Support\Traits\Macroable;

class Meta implements MetaInterface
{
    use Macroable,
        Concerns\ManageTitle,
        Concerns\ManageMetaTags,
        Concerns\ManageLinksTags,
        Concerns\ManagePlacements,
        Concerns\ManagePackages,
        Concerns\ManageAssets;

    const PLACEMENT_HEAD   = 'head';
    const PLACEMENT_FOOTER = 'footer';

    /**
     * @var Manager
     */
    protected $packageManager;

    /**
     * @param Manager $packageManager
     */
    public function __construct(Manager $packageManager)
    {
        $this->packageManager = $packageManager;
        $this->initPlacements();
    }

    /**
     * Add a custom tag
     *
     * @param string $name
     * @param TagInterface $tag
     *
     * @return $this
     */
    public function addTag(string $name, TagInterface $tag)
    {
        $this->placements->getBag($tag->getPlacement())->put($name, $tag);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTag(string $name): ?TagInterface
    {
        foreach ($this->getPlacements() as $placement) {
            if ($placement->has($name)) {
                return $placement->get($name);
            }
        }

        return null;
    }

    /**
     * @param TagsCollection $tags
     * @param string|null $placement
     */
    public function registerTags(TagsCollection $tags, string $placement = null)
    {
        foreach ($tags as $name => $tag) {
            $this->placement($placement ?: $tag->getPlacement())->put(
                $name, $tag
            );
        }
    }

    /**
     * @inheritdoc
     */
    public function removeTag(string $name): void
    {
        foreach ($this->getPlacements() as $placement) {
            $placement->forget($name);
        }
    }

    /**
     * @inheritdoc
     */
    public function reset(): void
    {
        foreach ($this->getPlacements() as $placement) {
            $placement->reset();
        }
    }

    /**
     * Remove HTML tags
     *
     * @param string $string
     *
     * @return string
     */
    protected function cleanString(string $string): string
    {
        return e(strip_tags($string));
    }

    /**
     * Get content as a string of HTML.
     * @return string
     */
    public function toHtml()
    {
        return $this->head()->toHtml();
    }

    public function __toString()
    {
        return $this->toHtml();
    }
}