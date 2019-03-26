<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Meta;
use PHPUnit\Framework\TestCase;

class PaginatorMetaTagsTest extends TestCase
{
    function test_prev_href_can_be_set()
    {
        $meta = new Meta();

        $meta->setPrevHref('http://site.com');

        $this->assertEquals(
            '<link rel="prev" href="http://site.com" />',
            $meta->getPrevHref()->toHtml()
        );
    }

    function test_prev_href_method_should_be_fluent()
    {
        $meta = new Meta();

        $this->assertEquals(
            $meta,
            $meta->setPrevHref('http://site.com')
        );
    }

    function test_prev_href_should_be_null_if_not_set()
    {
        $meta = new Meta();

        $this->assertNull($meta->getPrevHref());
    }

    function test_prev_href_string_should_be_cleaned()
    {
        $meta = new Meta();

        $meta->setPrevHref('<h5>http://site.com</h5>');

        $this->assertEquals(
            '<link rel="prev" href="http://site.com" />',
            $meta->getPrevHref()->toHtml()
        );
    }

    function test_next_href_can_be_set()
    {
        $meta = new Meta();

        $meta->setNextHref('http://site.com');

        $this->assertEquals(
            '<link rel="next" href="http://site.com" />',
            $meta->getNextHref()->toHtml()
        );
    }

    function test_next_href_method_should_be_fluent()
    {
        $meta = new Meta();

        $this->assertEquals(
            $meta,
            $meta->setNextHref('http://site.com')
        );
    }

    function test_next_href_should_be_null_if_not_set()
    {
        $meta = new Meta();

        $this->assertNull($meta->getNextHref());
    }

    function test_next_href_string_should_be_cleaned()
    {
        $meta = new Meta();

        $meta->setNextHref('<h5>http://site.com</h5>');

        $this->assertEquals(
            '<link rel="next" href="http://site.com" />',
            $meta->getNextHref()->toHtml()
        );
    }
}