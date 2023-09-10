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
    protected static function getFacadeAccessor(): string
    {
        return MetaInterface::class;
    }
}
