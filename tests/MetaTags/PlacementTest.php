<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Placement;
use Butschster\Head\MetaTags\Entities\Tag;
use Butschster\Tests\TestCase;

class PlacementTest extends TestCase
{
    function test_in_can_be_converted_to_html()
    {
        $placement = new Placement();

        $placement->add(new Tag('meta', [
            'attr' => 'value'
        ]));

        $placement->add(new Tag('meta', [
            'attr' => 'value1'
        ]));


        $this->assertStringContainsString('<meta attr="value">', $placement->toHtml());
        $this->assertStringContainsString('<meta attr="value1">', $placement->toHtml());
    }

}