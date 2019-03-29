<?php

namespace Butschster\Tests\MetaTags\Entities;

use Butschster\Head\MetaTags\Meta;
use Butschster\Head\MetaTags\Entities\Tag;
use Butschster\Tests\TestCase;

class TagTest extends TestCase
{
    function test_it_can_be_rendered_to_string()
    {
        $this->assertHtmlableEquals(
            '<meta name="custom" content="test data">',
            new Tag('meta', [
                'name' => 'custom',
                'content' => 'test data'
            ])
        );
    }

    function test_it_can_build_attributes()
    {
        $tag = new Tag('meta', [
            'name' => 'custom',
            'content' => 'test data'
        ]);

        $this->assertEquals(
            'name="custom" content="test data"',
            $tag->compiledAttributes()
        );
    }

    function test_tag_can_be_closed()
    {
        $this->assertHtmlableEquals(
            '<link rel="prev" href="http://site.com" />',
            new Tag('link', [
                'rel' => 'prev',
                'href' => 'http://site.com'
            ], true)
        );
    }

    function test_it_has_placement()
    {
        $tag = new Tag('link', [
            'rel' => 'prev',
            'href' => 'http://site.com'
        ], true);

        $this->assertEquals(Meta::PLACEMENT_HEAD, $tag->getPlacement());

        $tag->setPlacement('footer');

        $this->assertEquals('footer', $tag->getPlacement());
    }
}