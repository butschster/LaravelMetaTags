<?php

namespace Butschster\Head\MetaTags\Entities;

use Butschster\Head\MetaTags\Meta;

class Script extends Tag
{
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
     * @param string|null $placement
     */
    public function __construct(string $name, string $src, array $attributes = [], string $placement = null)
    {
        $this->name = $name;
        $this->src = $src;
        $this->placement = $placement ?: Meta::PLACEMENT_FOOTER;

        parent::__construct('script', $attributes, true);
    }

    /**
     * @return array
     */
    protected function getAttributes(): array
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