<?php

namespace Butschster\Head\Facades;

use Butschster\Head\MetaTags\MetaInterface;
use Illuminate\Support\Facades\Facade;

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