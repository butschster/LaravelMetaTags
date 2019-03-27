<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Meta;
use Butschster\Head\MetaTags\Tag;
use Butschster\Tests\TestCase;

class TagTest extends TestCase
{
    function test_it_can_be_rendered_to_string()
    {
        $tag = new Tag('meta', [
            'name' => 'custom',
            'content' => 'test data'
        ]);

        $this->assertEquals('<meta name="custom" content="test data">', $tag->toHtml());
    }

    function test_it_has_attributes()
    {
        $tag = new Tag('meta', $attributes = [
            'name' => 'custom',
            'content' => 'test data'
        ]);

        $this->assertEquals($attributes, $tag->getAttributes());
    }

    function test_it_can_build_attributes()
    {
        $tag = new Tag('meta', [
            'name' => 'custom',
            'content' => 'test data'
        ]);

        $this->assertEquals('name="custom" content="test data"', $tag->compiledAttributes());
    }

    function test_tag_can_be_closed()
    {
        $tag = new Tag('link', [
            'rel' => 'prev',
            'href' => 'http://site.com'
        ], true);

        $this->assertEquals('<link rel="prev" href="http://site.com" />', $tag->toHtml());
    }

    function test_it_has_placement()
    {
        $tag = new Tag('link', [
            'rel' => 'prev',
            'href' => 'http://site.com'
        ], true);

        $this->assertEquals(Meta::PLACEMENT_HEAD, $tag->placement());

        $tag->setPlacement('footer');

        $this->assertEquals('footer', $tag->placement());
    }
}