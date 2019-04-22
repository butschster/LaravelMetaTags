<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Tests\TestCase;

class TitleMetaTagsTest extends TestCase
{
    function test_title_can_be_set()
    {
        $meta = $this->makeMetaTags()
            ->setTitle('test title');

        $this->assertHtmlableEquals(
            '<title>test title</title>',
            $meta->getTitle()
        );
    }

    function test_title_can_be_null()
    {
        $meta = $this->makeMetaTags()
            ->setTitle(null);

        $this->assertHtmlableEquals(
            '<title></title>',
            $meta->getTitle()
        );
    }

    function test_title_can_be_prepend()
    {
        $meta = $this->makeMetaTags()
            ->setTitle('test title')
            ->prependTitle('prepend part');

        $this->assertHtmlableEquals(
            '<title>prepend part | test title</title>',
            $meta->getTitle()
        );
    }

    function test_title_can_be_prepend_as_null_value()
    {
        $meta = $this->makeMetaTags()
            ->setTitle('test title')
            ->prependTitle(null);

        $this->assertHtmlableEquals(
            '<title>test title</title>',
            $meta->getTitle()
        );
    }

    function test_prepend_title_should_be_cleaned()
    {
        $meta = $this->makeMetaTags()
            ->setTitle('test title')
            ->prependTitle('<h5>prepend part</h5>');

        $this->assertHtmlableEquals(
            '<title>prepend part | test title</title>',
            $meta->getTitle()
        );
    }

    function test_title_can_be_prepend_if_title_not_set()
    {
        $meta = $this->makeMetaTags()
            ->prependTitle('prepend part');

        $this->assertHtmlableEquals(
            '<title>prepend part</title>',
            $meta->getTitle()
        );
    }

    function test_prepend_separator_can_be_changed()
    {
        $meta = $this->makeMetaTags()
            ->setTitle('test title')
            ->setTitleSeparator('-')
            ->prependTitle('prepend part');

        $this->assertHtmlableEquals(
            '<title>prepend part - test title</title>',
            $meta->getTitle()
        );
    }

    function test_set_title_method_should_be_fluent()
    {
        $meta = $this->makeMetaTags();

        $this->assertEquals($meta, $meta->setTitle('test title'));
    }

    function test_title_string_should_be_cleaned()
    {
        $meta = $this->makeMetaTags()
            ->setTitle('<h5>test title</h5>');

        $this->assertHtmlableEquals(
            '<title>test title</title>',
            $meta->getTitle()
        );
    }

    function test_title_can_be_limited()
    {
        $this->assertHtmlableContains(
            '<title>test...</title>',
            $this->makeMetaTags()->setTitle('test title', 4)
        );
    }

    function test_gets_max_keywords_length_from_config_by_default()
    {
        $config = $this->makeConfig();
        $config->shouldReceive('get')->once()->with('meta_tags.title.max_length', null)->andReturn(4);

        $this->assertHtmlableContains(
            '<title>test...</title>',
            $this->makeMetaTags(null, $config)->setTitle('test title')
        );
    }
}