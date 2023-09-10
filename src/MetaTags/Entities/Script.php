<?php

namespace Butschster\Head\MetaTags\Entities;

use Butschster\Head\MetaTags\Meta;

class Script extends Tag
{
    public function __construct(
        protected string $name,
        protected string $src,
        array $attributes = [],
        string $placement = null
    ) {
        $this->placement = $placement ?: Meta::PLACEMENT_FOOTER;

        parent::__construct('script', $attributes, true);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSrc(): string
    {
        return $this->src;
    }

    protected function getAttributes(): array
    {
        return array_merge([
            'src' => $this->src,
        ], parent::getAttributes());
    }

    public function toHtml(): string
    {
        return sprintf(
            '<%s %s></%s>',
            $this->tagName,
            $this->compiledAttributes(),
            $this->tagName
        );
    }
}
