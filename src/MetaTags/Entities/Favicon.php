<?php

namespace Butschster\Head\MetaTags\Entities;

class Favicon extends Tag
{
    /**
     * @var string
     */
    protected $href;

    /**
     * @param string $href
     * @param array $attributes
     */
    public function __construct(string $href, array $attributes = [])
    {
        $this->href = $href;

        parent::__construct('link', $attributes, false);
    }

    /**
     * @return array
     */
    protected function getAttributes(): array
    {
        return array_merge([
            'rel' => 'icon',
            'type' => $this->getType(),
            'href' => $this->href,
        ], parent::getAttributes());
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        $ext = pathinfo($this->href, PATHINFO_EXTENSION);

        switch ($ext) {
            case 'png':
                return 'image/png';
            case 'gif':
                return 'image/gif';
            case 'svg':
                return 'image/svg+xml';
        }

        return 'image/x-icon';
    }
}