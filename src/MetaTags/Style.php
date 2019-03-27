<?php

namespace Butschster\Head\MetaTags;

use Butschster\Head\MetaTags\Tag;
use Butschster\Head\Packages\Concerns\Dependencies;

class Style extends Tag
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
     */
    public function __construct(string $name, string $src, array $attributes = [], array $dependency = [])
    {
        $this->name = $name;
        $this->src = $src;
        $this->with($dependency);

        parent::__construct('link', $attributes, true);
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return array_merge([
            'media' => 'all',
            'type' => 'text/css',
            'rel' => 'stylesheet',
            'href' => $this->src,
        ], parent::getAttributes());
    }
}