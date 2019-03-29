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
        $tag->shouldReceive('getPlacement')->once()->andReturn(Meta::PLACEMENT_HEAD);
        $tag->shouldReceive('__toString')->andReturn('<script src="http://site.com"></script>');

        $this->assertHtmlableContains(
            '<script src="http://site.com"></script>',
            $meta->addTag('custom', $tag)->getTag('custom')
        );
    }

    function test_custom_tag_can_be_placed_into_different_placements()
    {
        $meta = $this->makeMetaTags();

        $tag = $this->makeTag();
        $tag->shouldReceive('getPlacement')->once()->andReturn('footer');

        $tag1 = $this->makeTag();
        $tag1->shouldReceive('getPlacement')->once()->andReturn('head');

        $meta->addTag('tag1', $tag)->addTag('tag2', $tag1);

        $this->assertFalse($meta->placement('head')->has('tag1'));
        $this->assertTrue($meta->placement('footer')->has('tag1'));

        $this->assertFalse($meta->placement('footer')->has('tag2'));
        $this->assertTrue($meta->placement('head')->has('tag2'));
    }

    function test_tag_can_be_removed_from_all_placements()
    {
        $meta = $this->makeMetaTags();

        $tag = $this->makeTag();
        $tag->shouldReceive('getPlacement')->once()->andReturn('footer');

        $tag1 = $this->makeTag();
        $tag1->shouldReceive('getPlacement')->once()->andReturn('head');

        $meta->addTag('tag1', $tag);
        $meta->addTag('tag2', $tag1);

        $meta->removeTag('tag1');
        $this->assertFalse($meta->placement('footer')->has('tag1'));
        $this->assertTrue($meta->placement('head')->has('tag2'));

        $meta->removeTag('tag2');
        $this->assertFalse($meta->placement('head')->has('tag2'));
    }
}