<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\PlacementsBag;
use Butschster\Tests\TestCase;

class PlacementsBagTest extends TestCase
{
    function test_a_placement_can_be_add()
    {
        $placements = new PlacementsBag();
        $placement = $placements->makeBug('test');

        $this->assertEquals($placement, $placements->getBag('test'));
    }
}