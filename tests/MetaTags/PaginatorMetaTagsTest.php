<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Meta;
use Illuminate\Contracts\Pagination\Paginator;
use PHPUnit\Framework\TestCase;
use Mockery as m;

class PaginatorMetaTagsTest extends TestCase
{
    function test_its_can_be_set_from_paginator()
    {
        $meta = new Meta();

        $paginator = m::mock(Paginator::class);

        $paginator->shouldReceive('nextPageUrl')->once()->andReturn('http://site.com/next');
        $paginator->shouldReceive('previousPageUrl')->once()->andReturn('http://site.com/prev');
        $paginator->shouldReceive('currentPage')->once()->andReturn(1);
        $paginator->shouldReceive('url')->once()->andReturn('http://site.com/1');

        $meta->setPaginationLinks($paginator);

        $this->assertStringContainsString('<link rel="next" href="http://site.com/next" />', $meta->getNextHref()->toHtml());
        $this->assertStringContainsString('<link rel="prev" href="http://site.com/prev" />', $meta->getPrevHref()->toHtml());
        $this->assertStringContainsString('<link rel="canonical" href="http://site.com/1" />', $meta->getCanonical()->toHtml());
    }

    function test_canonical_can_be_set()
    {
        $meta = new Meta();

        $meta->setCanonical('http://site.com');

        $this->assertEquals(
            '<link rel="canonical" href="http://site.com" />',
            $meta->getCanonical()->toHtml()
        );
    }

    function test_canonical_method_should_be_fluent()
    {
        $meta = new Meta();

        $this->assertEquals(
            $meta,
            $meta->setCanonical('http://site.com')
        );
    }

    function test_canonical_should_be_null_if_not_set()
    {
        $meta = new Meta();

        $this->assertNull($meta->getCanonical());
    }

    function test_canonical_string_should_be_cleaned()
    {
        $meta = new Meta();

        $meta->setCanonical('<h5>http://site.com</h5>');

        $this->assertEquals(
            '<link rel="canonical" href="http://site.com" />',
            $meta->getCanonical()->toHtml()
        );
    }

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