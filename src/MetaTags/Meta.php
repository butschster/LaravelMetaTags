<?php

namespace Butschster\Head\MetaTags;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\Packages\Manager;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Traits\Macroable;

class Meta implements MetaInterface, \Stringable
{
    use Macroable;
    use Concerns\ManageTitle;
    use Concerns\ManageMetaTags;
    use Concerns\ManageLinksTags;
    use Concerns\ManagePlacements;
    use Concerns\ManagePackages;
    use Concerns\ManageAssets;
    use Concerns\InitializeDefaults;

    public const PLACEMENT_HEAD = 'head';

    public const PLACEMENT_FOOTER = 'footer';

    public function __construct(
        protected Manager $packageManager,
        private ?Repository $config = null,
    ) {
        $this->initPlacements();
    }

    public function getTag(string $name): ?TagInterface
    {
        foreach ($this->getPlacements() as $placement) {
            if ($placement->has($name)) {
                return $placement->get($name);
            }
        }

        return null;
    }

    public function addTag(string $name, TagInterface $tag, ?string $placement = null): self
    {
        $this->placement($placement ?: $tag->getPlacement())->put($name, $tag);

        return $this;
    }

    public function registerTags(TagsCollection $tags, ?string $placement = null): self
    {
        foreach ($tags as $name => $tag) {
            $this->addTag($name, $tag, $placement);
        }

        return $this;
    }

    public function removeTag(string $name): self
    {
        foreach ($this->getPlacements() as $placement) {
            $placement->forget($name);
        }

        return $this;
    }

    public function reset(): self
    {
        foreach ($this->getPlacements() as $placement) {
            $placement->reset();
        }

        return $this;
    }

    /**
     * Get content as a string of HTML.
     */
    public function toHtml(): string
    {
        return $this->head()->toHtml();
    }

    public function __toString(): string
    {
        return $this->toHtml();
    }

    /**
     * Remove HTML tags
     */
    protected function cleanString(?string $string): string
    {
        return e(strip_tags($string));
    }

    /**
     * Get value from config repository
     * If config repository is not set, it returns default value
     */
    protected function config(string $key, mixed $default = null): mixed
    {
        if ($this->config === null) {
            return $default;
        }

        return $this->config->get('meta_tags.' . $key, $default);
    }

    public function toArray(): array
    {
        return $this->placements->toArray();
    }
}
