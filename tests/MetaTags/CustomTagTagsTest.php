<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Meta;
use Butschster\Head\MetaTags\TagInterface;
use Butschster\Tests\TestCase;
use Mockery as m;

class CustomTagTagsTest extends TestCase
{
    function test_custom_meta_tag_can_be_set()
    {
        $meta = $this->makeMetaTags();
        $tag = m::mock(TagInterface::class);
        $tag->shouldReceive('placement')->once()->andReturn(Meta::PLACEMENT_HEAD);
        $tag->shouldReceive('toHtml')->andReturn('<script src="http://site.com"></script>');

        $meta->addTag('custom', $tag);

        $this->assertEquals(
            '<script src="http://site.com"></script>',
            $meta->getMeta('custom')->toHtml()
        );
    }
}