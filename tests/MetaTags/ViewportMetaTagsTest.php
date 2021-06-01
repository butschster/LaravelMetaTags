<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Tests\TestCase;

class ViewportMetaTagsTest extends TestCase
{
    function test_viewport_can_be_set()
    {
        $meta = $this->makeMetaTags()
            ->setViewport('width=device-width, initial-scale=1');

        $this->assertHtmlableEquals(
            '<meta name="viewport" content="width=device-width, initial-scale=1">',
            $meta->getViewport()
        );
    }

    function test_set_viewport_method_should_be_fluent()
    {
        $meta = $this->makeMetaTags();

        $this->assertEquals(
            $meta,
            $meta->setViewport('width=device-width, initial-scale=1')
        );
    }

    function test_viewport_should_be_null_if_not_set()
    {
        $meta = $this->makeMetaTags();

        $this->assertNull($meta->getViewport());
    }

    function test_viewport_string_should_be_cleaned()
    {
        $meta = $this->makeMetaTags()
            ->setViewport('<h5>width=device-width, initial-scale=1</h5>');

        $this->assertHtmlableEquals(
            '<meta name="viewport" content="width=device-width, initial-scale=1">',
            $meta->getViewport()
        );
    }

    function test_converts_to_array()
    {
        $this->assertEquals(
            [
                'content' => 'width=device-width, initial-scale=1',
                'tag' => 'meta',
                'name' => 'viewport',
                'type' => 'tag',
            ],
            $this->makeMetaTags()->setViewport('width=device-width, initial-scale=1')->getViewport()->toArray()
        );
    }
}
