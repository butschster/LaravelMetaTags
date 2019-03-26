<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Meta;
use PHPUnit\Framework\TestCase;

class TitleMetaTagsTest extends TestCase
{
    function test_title_can_be_set()
    {
        $meta = new Meta();

        $meta->setTitle('test title');

        $this->assertEquals(
            '<title>test title</title>',
            $meta->getTitle()->toHtml()
        );
    }

    function test_title_can_be_prepend()
    {
        $meta = new Meta();

        $meta->setTitle('test title');

        $meta->prependTitle('prepend part');

        $this->assertEquals(
            '<title>prepend part | test title</title>',
            $meta->getTitle()->toHtml()
        );
    }

    function test_preppend_title_should_be_cleaned()
    {
        $meta = new Meta();

        $meta->setTitle('test title');

        $meta->prependTitle('<h5>prepend part</h5>');

        $this->assertEquals(
            '<title>prepend part | test title</title>',
            $meta->getTitle()->toHtml()
        );
    }

    function test_title_can_be_prepend_if_title_not_set()
    {
        $meta = new Meta();

        $meta->prependTitle('prepend part');

        $this->assertEquals(
            '<title>prepend part</title>',
            $meta->getTitle()->toHtml()
        );
    }

    function test_prepend_separator_can_be_changed()
    {
        $meta = new Meta();

        $meta->setTitle('test title')
            ->setTitleSeparator('-')
            ->prependTitle('prepend part');

        $this->assertEquals(
            '<title>prepend part - test title</title>',
            $meta->getTitle()->toHtml()
        );
    }

    function test_set_title_method_should_be_fluent()
    {
        $meta = new Meta();

        $this->assertEquals(
            $meta,
            $meta->setTitle('test title')
        );
    }

    function test_title_string_should_be_cleaned()
    {
        $meta = new Meta();

        $meta->setTitle('<h5>test title</h5>');

        $this->assertEquals(
            '<title>test title</title>',
            $meta->getTitle()->toHtml()
        );
    }
}