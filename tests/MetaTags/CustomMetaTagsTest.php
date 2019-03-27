<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Tests\TestCase;

class CustomMetaTagsTest extends TestCase
{
    function test_custom_meta_tag_can_be_set()
    {
        $meta = $this->makeMetaTags();

        $meta->addMeta('custom', [
            'name' => 'custom',
            'content' => 'test data'
        ]);

        $this->assertEquals(
            '<meta name="custom" content="test data">',
            $meta->getMeta('custom')->toHtml()
        );
    }

    function test_meta_tag_can_be_deleted_by_name()
    {
        $meta = $this->makeMetaTags();

        $meta->addMeta('test1', [
            'name' => 'custom',
            'content' => 'test data'
        ]);

        $meta->removeMeta('test1');

        $this->assertNull(
            $meta->getMeta('test1')
        );
    }
}