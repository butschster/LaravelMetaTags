<?php

namespace Butschster\Head\MetaTags\Entities;

class Style extends Tag
{
    public function __construct(
        protected string $name,
        protected string $src,
        array $attributes = [],
    ) {
        parent::__construct('link', $attributes, false);
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
            'media' => 'all',
            'type' => 'text/css',
            'rel' => 'stylesheet',
            'href' => $this->src,
        ], parent::getAttributes());
    }
}
