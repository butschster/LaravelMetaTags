<?php

namespace Butschster\Tests\MetaTags;

use Illuminate\Contracts\Pagination\Paginator;
use Butschster\Tests\TestCase;
use Mockery as m;

class PaginatorMetaTagsTest extends TestCase
{
    function test_its_can_be_set_from_paginator()
    {
        $meta = $this->makeMetaTags();

        $paginator = m::mock(Paginator::class);

        $paginator->shouldReceive('nextPageUrl')->once()->andReturn('http://site.com/next');
        $paginator->shouldReceive('previousPageUrl')->once()->andReturn('http://site.com/prev');
        $paginator->shouldReceive('currentPage')->once()->andReturn(1);
        $paginator->shouldReceive('url')->once()->andReturn('http://site.com/1');

        $meta->setPaginationLinks($paginator);

        $this->assertHtmlableContains(
            '<link rel="next" href="http://site.com/next">',
            $meta->getNextHref()
        );

        $this->assertHtmlableContains(
            '<link rel="prev" href="http://site.com/prev">',
            $meta->getPrevHref()
        );

        $this->assertHtmlableContains(
            '<link rel="canonical" href="http://site.com/1">',
            $meta->getCanonical()
        );
    }

    function test_canonical_can_be_set()
    {
        $meta = $this->makeMetaTags()
            ->setCanonical('http://site.com');

        $this->assertHtmlableEquals(
            '<link rel="canonical" href="http://site.com">',
            $meta->getCanonical()
        );
    }

    function test_canonical_method_should_be_fluent()
    {
        $meta = $this->makeMetaTags();

        $this->assertEquals($meta, $meta->setCanonical('http://site.com'));
    }

    function test_canonical_should_be_null_if_not_set()
    {
        $meta = $this->makeMetaTags();

        $this->assertNull($meta->getCanonical());
    }

    function test_canonical_string_should_be_cleaned()
    {
        $meta = $this->makeMetaTags()
            ->setCanonical('<h5>http://site.com</h5>');

        $this->assertHtmlableEquals(
            '<link rel="canonical" href="http://site.com">',
            $meta->getCanonical()
        );
    }

    function test_prev_href_can_be_set()
    {
        $meta = $this->makeMetaTags()
            ->setPrevHref('http://site.com');

        $this->assertHtmlableEquals(
            '<link rel="prev" href="http://site.com">',
            $meta->getPrevHref()
        );
    }

    function test_prev_href_method_should_be_fluent()
    {
        $meta = $this->makeMetaTags();

        $this->assertEquals($meta, $meta->setPrevHref('http://site.com'));
    }

    function test_prev_href_should_be_null_if_not_set()
    {
        $meta = $this->makeMetaTags();

        $this->assertNull($meta->getPrevHref());
    }

    function test_prev_href_string_should_be_cleaned()
    {
        $meta = $this->makeMetaTags()
            ->setPrevHref('<h5>http://site.com</h5>');

        $this->assertHtmlableEquals(
            '<link rel="prev" href="http://site.com">',
            $meta->getPrevHref()
        );
    }

    function test_prev_href_can_be_null()
    {
        $meta = $this->makeMetaTags()
            ->setPrevHref(null);

        $this->assertNull($meta->getPrevHref());
    }

    function test_next_href_can_be_set()
    {
        $meta = $this->makeMetaTags()
            ->setNextHref('http://site.com');

        $this->assertHtmlableEquals(
            '<link rel="next" href="http://site.com">',
            $meta->getNextHref()
        );
    }

    function test_next_href_method_should_be_fluent()
    {
        $meta = $this->makeMetaTags();

        $this->assertEquals($meta, $meta->setNextHref('http://site.com'));
    }

    function test_next_href_should_be_null_if_not_set()
    {
        $meta = $this->makeMetaTags();

        $this->assertNull($meta->getNextHref());
    }

    function test_next_href_can_be_null()
    {
        $meta = $this->makeMetaTags()
            ->setNextHref(null);

        $this->assertNull($meta->getNextHref());
    }

    function test_next_href_string_should_be_cleaned()
    {
        $meta = $this->makeMetaTags()
            ->setNextHref('<h5>http://site.com</h5>');

        $this->assertHtmlableEquals(
            '<link rel="next" href="http://site.com">',
            $meta->getNextHref()
        );
    }
}