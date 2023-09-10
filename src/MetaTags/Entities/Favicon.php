<?php

namespace Butschster\Head\MetaTags\Entities;

class Favicon extends Tag
{
    public function __construct(
        protected string $href,
        array $attributes = [],
    ) {
        parent::__construct(tagName: 'link', attributes: $attributes, closeTag: false);
    }

    public function getHref(): string
    {
        return $this->href;
    }

    protected function getAttributes(): array
    {
        return array_merge([
            'rel' => 'icon',
            'type' => $this->getType(),
            'href' => $this->href,
        ], parent::getAttributes());
    }

    public function getType(): string
    {
        $ext = pathinfo($this->href, PATHINFO_EXTENSION);
        return match ($ext) {
            'png' => 'image/png',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            default => 'image/x-icon',
        };
    }
}
