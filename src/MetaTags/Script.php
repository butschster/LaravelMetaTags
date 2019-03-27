<?php

namespace Butschster\Head\MetaTags;

use Butschster\Head\MetaTags\Meta;
use Butschster\Head\MetaTags\Tag;
use Butschster\Head\Packages\Concerns\Dependencies;

class Script extends Tag
{
    use Dependencies;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $src;

    /**
     * @param string $name
     * @param string $src
     * @param array $attributes
     * @param array $dependency
     * @param string|null $placement
     */
    public function __construct(string $name, string $src, array $attributes = [], array $dependency = [], string $placement = null)
    {
        $this->name = $name;
        $this->src = $src;
        $this->with($dependency);
        $this->placement = $placement ?: Meta::PLACEMENT_FOOTER;

        parent::__construct('script', $attributes, true);
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return array_merge([
            'src' => $this->src,
        ], parent::getAttributes());
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return sprintf(
            '<%s %s></%s>',
            $this->tagName,
            $this->compiledAttributes(),
            $this->tagName
        );
    }
}