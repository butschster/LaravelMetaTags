<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Meta;
use PHPUnit\Framework\TestCase;

class DescriptionMetaTagsTest extends TestCase
{
    function test_description_can_be_set()
    {
        $meta = new Meta();

        $meta->setDescription('test description');

        $this->assertEquals(
            '<meta name="description" content="test description">',
            $meta->getDescription()->toHtml()
        );
    }

    function test_set_description_method_should_be_fluent()
    {
        $meta = new Meta();

        $this->assertEquals(
            $meta,
            $meta->setDescription('test description')
        );
    }

    function test_description_should_be_null_if_not_set()
    {
        $meta = new Meta();

        $this->assertNull($meta->getDescription());
    }

    function test_description_string_should_be_cleaned()
    {
        $meta = new Meta();

        $meta->setDescription('<h5>test description</h5>');

        $this->assertEquals(
            '<meta name="description" content="test description">',
            $meta->getDescription()->toHtml()
        );
    }
}