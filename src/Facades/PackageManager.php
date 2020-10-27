<?php

namespace Butschster\Head\Facades;

use Butschster\Head\Contracts\Packages\ManagerInterface;
use Illuminate\Support\Facades\Facade;

/**
 * Class Meta
 * @package Butschster\Head\Facades
 * @mixin ManagerInterface
 */
class PackageManager extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ManagerInterface::class;
    }
}
