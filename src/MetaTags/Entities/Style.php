<?php

namespace Butschster\Head\MetaTags\Entities;

class Style extends Tag
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
     */
    public function __construct(string $name, string $src, array $attributes = [])
    {
        $this->name = $name;
        $this->src = $src;

        parent::__construct('link', $attributes, false);
    }

    /**
     * @return array
     */
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