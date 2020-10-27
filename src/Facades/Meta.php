<?php

namespace Butschster\Head\Facades;

use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Illuminate\Support\Facades\Facade;

/**
 * Class Meta
 * @package Butschster\Head\Facades
 * @mixin MetaInterface
 */
class Meta extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return MetaInterface::class;
    }
}
