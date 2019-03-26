<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Meta;
use PHPUnit\Framework\TestCase;

class ViewportMetaTagsTest extends TestCase
{
    function test_viewport_can_be_set()
    {
        $meta = new Meta();

        $meta->setViewport('width=device-width, initial-scale=1');

        $this->assertEquals(
            '<meta name="viewport" content="width=device-width, initial-scale=1">',
            $meta->getViewport()->toHtml()
        );
    }

    function test_set_viewport_method_should_be_fluent()
    {
        $meta = new Meta();

        $this->assertEquals(
            $meta,
            $meta->setViewport('width=device-width, initial-scale=1')
        );
    }

    function test_viewport_should_be_null_if_not_set()
    {
        $meta = new Meta();

        $this->assertNull($meta->getViewport());
    }

    function test_viewport_string_should_be_cleaned()
    {
        $meta = new Meta();

        $meta->setViewport('<h5>width=device-width, initial-scale=1</h5>');

        $this->assertEquals(
            '<meta name="viewport" content="width=device-width, initial-scale=1">',
            $meta->getViewport()->toHtml()
        );
    }
}