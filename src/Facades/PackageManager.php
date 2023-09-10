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
    protected static function getFacadeAccessor(): string
    {
        return ManagerInterface::class;
    }
}
