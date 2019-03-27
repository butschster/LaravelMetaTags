<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Tests\TestCase;

class DescriptionMetaTagsTest extends TestCase
{
    function test_description_can_be_set()
    {
        $meta = $this->makeMetaTags();

        $meta->setDescription('test description');

        $this->assertEquals(
            '<meta name="description" content="test description">',
            $meta->getDescription()->toHtml()
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

        $meta->setDescription('<h5>test description</h5>');

        $this->assertEquals(
            '<meta name="description" content="test description">',
            $meta->getDescription()->toHtml()
        );
    }
}