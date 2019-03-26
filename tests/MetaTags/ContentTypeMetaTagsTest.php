<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Meta;
use PHPUnit\Framework\TestCase;

class ContentTypeMetaTagsTest extends TestCase
{
    function test_content_type_can_be_set()
    {
        $meta = new Meta();

        $meta->setContentType('text/html');

        $this->assertEquals(
            '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">',
            $meta->getContentType()->toHtml()
        );

        $meta->setContentType('text/html', 'ISO-8859-1');

        $this->assertEquals(
            '<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">',
            $meta->getContentType()->toHtml()
        );
    }

    function test_set_content_type_method_should_be_fluent()
    {
        $meta = new Meta();

        $this->assertEquals(
            $meta,
            $meta->setContentType('text/html')
        );
    }

    function test_content_type_should_be_null_if_not_set()
    {
        $meta = new Meta();

        $this->assertNull($meta->getContentType());
    }

    function test_content_type_string_should_be_cleaned()
    {
        $meta = new Meta();

        $meta->setContentType('<h5>text/html</h5>');

        $this->assertEquals(
            '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">',
            $meta->getContentType()->toHtml()
        );
    }
}