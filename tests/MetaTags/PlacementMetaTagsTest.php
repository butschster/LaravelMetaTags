<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Placement;
use Butschster\Tests\TestCase;

class PlacementMetaTagsTest extends TestCase
{
    function test_it_has_head_placement()
    {
        $meta = $this->makeMetaTags();

        $this->assertInstanceOf(Placement::class, $meta->head());
    }

    function test_it_has_footer_placement()
    {
        $meta = $this->makeMetaTags();

        $this->assertInstanceOf(Placement::class, $meta->footer());
    }

    function test_gets_specific_placement()
    {
        $meta = $this->makeMetaTags();

        $this->assertInstanceOf(Placement::class, $meta->placement('test'));
    }

    function test_placement_should_be_created_only_once()
    {
        $meta = $this->makeMetaTags();
        $placement = $meta->placement('test');
        $footer = $meta->footer();
        $head = $meta->head();

        $this->assertEquals($placement, $meta->placement('test'));
        $this->assertEquals($footer, $meta->footer());
        $this->assertEquals($head, $meta->head());
    }
}