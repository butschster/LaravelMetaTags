<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Tests\TestCase;

class DescriptionMetaTagsTest extends TestCase
{
    function test_description_can_be_set()
    {
        $this->assertHtmlableEquals(
            '<meta name="description" content="test description">',
            $this->makeMetaTags()->setDescription('test description')->getDescription()
        );
    }

    function test_set_description_method_should_be_fluent()
    {
        $meta = $this->makeMetaTags();

        $this->assertEquals(
            $meta,
            $meta->setDescription('test description')
        );
    }

    function test_description_should_be_null_if_not_set()
    {
        $meta = $this->makeMetaTags();

        $this->assertNull($meta->getDescription());
    }

    function test_description_string_should_be_cleaned()
    {
        $meta = $this->makeMetaTags();

        $this->assertHtmlableEquals(
            '<meta name="description" content="test description">',
            $meta->setDescription('<h5>test description</h5>')->getDescription()
        );
    }
}