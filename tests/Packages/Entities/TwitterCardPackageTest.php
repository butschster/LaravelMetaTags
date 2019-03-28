<?php

namespace Butschster\Tests\Packages\Entities;

use Butschster\Head\Packages\Entities\TwitterCardPackage;
use Butschster\Tests\TestCase;

class TwitterCardPackageTest extends TestCase
{
    function test_a_title_can_be_set()
    {
        $package = new TwitterCardPackage('twitter');
    }
}