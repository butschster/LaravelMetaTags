<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Tests\TestCase;

class ContentTypeMetaTagsTest extends TestCase
{
    function test_content_type_can_be_set()
    {
        $meta = $this->makeMetaTags();

        $this->assertHtmlableEquals(
            '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">',
            $meta->setContentType('text/html')->getContentType()
        );

        $this->assertHtmlableEquals(
            '<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">',
            $meta->setContentType('text/html', 'ISO-8859-1')->getContentType()
        );
    }

    function test_set_content_type_method_should_be_fluent()
    {
        $meta = $this->makeMetaTags();

        $this->assertEquals(
            $meta,
            $meta->setContentType('text/html')
        );
    }

    function test_content_type_should_be_null_if_not_set()
    {
        $this->assertNull(
            $this->makeMetaTags()
                ->getContentType()
        );
    }

    function test_content_type_string_should_be_cleaned()
    {
        $this->assertHtmlableEquals(
            '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">',
            $this->makeMetaTags()
                ->setContentType('<h5>text/html</h5>')
                ->getContentType()
        );
    }

    function test_convert_to_array()
    {
        $meta = $this->makeMetaTags();

        $this->assertEquals([
            'http-equiv' => 'Content-Type',
            'content' => 'text/html; charset=ISO-8859-1',
            'type' => 'tag',
            'tag' => 'meta',
        ], $meta->setContentType('text/html', 'ISO-8859-1')->getContentType()->toArray());
    }
}
