<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Meta;
use Butschster\Tests\TestCase;

class CustomTagTagsTest extends TestCase
{
    function test_custom_meta_tag_can_be_set()
    {
        $meta = $this->makeMetaTags();
        $tag = $this->makeTag();
        $tag->shouldReceive('placement')->once()->andReturn(Meta::PLACEMENT_HEAD);
        $tag->shouldReceive('toHtml')->andReturn('<script src="http://site.com"></script>');

        $meta->addTag('custom', $tag);

        $this->assertEquals(
            '<script src="http://site.com"></script>',
            $meta->getTag('custom')->toHtml()
        );
    }
}