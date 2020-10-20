<?php

namespace Butschster\Tests\MetaTags\Entities;

use Butschster\Head\MetaTags\Meta;
use Butschster\Head\MetaTags\Entities\Tag;
use Butschster\Tests\TestCase;

class TagTest extends TestCase
{
    function test_attribute_value_can_be_callable()
    {
        $this->assertHtmlableEquals(
            '<meta name="custom" content="test data">',
            new Tag('meta', [
                'name' => 'custom',
                'content' => function () {
                    return 'test data';
                }
            ])
        );
    }

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
            '<link rel="prev" href="http://site.com">',
            new Tag('link', [
                'rel' => 'prev',
                'href' => 'http://site.com'
            ], false)
        );
    }

    function test_it_has_placement()
    {
        $tag = new Tag('link', [
            'rel' => 'prev',
            'href' => 'http://site.com'
        ], false);

        $this->assertEquals(Meta::PLACEMENT_HEAD, $tag->getPlacement());

        $tag->setPlacement('footer');

        $this->assertEquals('footer', $tag->getPlacement());
    }

    function test_it_can_be_made()
    {
        $tag = Tag::make('meta', [
            'name' => 'description',
            'content' => 'Another cool description'
        ]);

        $this->assertHtmlableEquals(
            '<meta name="description" content="Another cool description">',
            $tag
        );

        $tag = Tag::make('meta', [
            'name' => 'description',
            'content' => 'Another cool description'
        ], false);

        $this->assertHtmlableEquals(
            '<meta name="description" content="Another cool description">',
            $tag
        );
    }

    function test_a_link_can_be_made()
    {
        $tag = Tag::link([
            'rel' => 'prev',
            'href' => 'http://site.com'
        ]);

        $this->assertHtmlableEquals(
            '<link rel="prev" href="http://site.com">',
            $tag
        );
    }

    function test_a_meta_can_be_made()
    {
        $tag = Tag::meta([
            'name' => 'description',
            'content' => 'Another cool description'
        ]);

        $this->assertHtmlableEquals(
            '<meta name="description" content="Another cool description">',
            $tag
        );
    }

    function test_by_default_tag_is_visible()
    {
        $tag = Tag::meta([
            'name' => 'description',
            'content' => 'Another cool description'
        ]);

        $this->assertTrue($tag->isVisible());
    }

    function test_visibility_condition_can_be_set()
    {
        $tag = Tag::meta([
            'name' => 'description',
            'content' => 'Another cool description'
        ]);

        // Make it invisible
        $this->assertFalse($tag->visibleWhen(function () {return false;})->isVisible());

        // Make it visible
        $this->assertTrue($tag->visibleWhen(function () {return true;})->isVisible());
    }
}
