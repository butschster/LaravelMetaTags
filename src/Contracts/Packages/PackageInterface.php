<?php

namespace Butschster\Head\Contracts\Packages;

use Butschster\Head\MetaTags\TagsCollection;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

interface PackageInterface extends Htmlable, Arrayable
{
    /**
     * Get the package name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the collection of tags
     *
     * @return TagsCollection
     */
    public function getTags(): TagsCollection;
}
