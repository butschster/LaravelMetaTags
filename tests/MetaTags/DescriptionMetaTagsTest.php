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

    function test_description_can_be_null()
    {
        $this->assertHtmlableEquals(
            '<meta name="description" content="">',
            $this->makeMetaTags()->setDescription(null)->getDescription()
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

    function test_description_can_be_limited()
    {
        $meta = $this->makeMetaTags();
        $this->assertHtmlableContains(
            '<meta name="description" content="test...">',
            $meta->setDescription('test description', 4)
        );
    }

    function test_gets_max_description_length_from_config_by_default()
    {
        $config = $this->makeConfig();
        $config->shouldReceive('get')->once()->with('meta_tags.description.max_length', null)->andReturn(4);

        $this->assertHtmlableContains(
            '<meta name="description" content="test...">',
            $this->makeMetaTags(null, $config)->setDescription('test description')
        );
    }

    function test_convert_to_array()
    {
        $this->assertEquals([
            'content' => 'test description',
            'type' => 'tag',
            'tag' => 'meta',
            'name' => 'description',
        ], $this->makeMetaTags()->setDescription('test description')->getDescription()->toArray());
    }
}
