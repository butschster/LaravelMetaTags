<?php

namespace Butschster\Tests\MetaTags\Entities;

use Butschster\Head\MetaTags\Entities\Style;
use Butschster\Tests\TestCase;

class StyleTest extends TestCase
{
    function test_it_can_be_created()
    {
        $style = new Style('style_name', 'http://site.com', [
            'type' => 'text/test',
            'media' => 'test',
            'rel' => 'css'
        ]);


        $this->assertEquals(
            '<link media="test" type="text/test" rel="css" href="http://site.com" />',
            $style->toHtml()
        );
    }

    function test_if_media_attribute_not_set_use_default_value()
    {
        $style = new Style('style_name', 'http://site.com', [
            'type' => 'text/test',
            'rel' => 'css'
        ]);

        $this->assertEquals(
            '<link media="all" type="text/test" rel="css" href="http://site.com" />',
            $style->toHtml()
        );
    }

    function test_if_type_attribute_not_set_use_default_value()
    {
        $style = new Style('style_name', 'http://site.com', [
            'rel' => 'css'
        ]);

        $this->assertEquals(
            '<link media="all" type="text/css" rel="css" href="http://site.com" />',
            $style->toHtml()
        );
    }

    function test_if_rek_attribute_not_set_use_default_value()
    {
        $style = new Style('style_name', 'http://site.com');

        $this->assertEquals(
            '<link media="all" type="text/css" rel="stylesheet" href="http://site.com" />',
            $style->toHtml()
        );
    }

    function test_in_can_have_dependencies()
    {
        $style = new Style('style_name', 'http://site.com', [
            'rel' => 'css'
        ], ['jquery', 'vuejs']);

        $this->assertEquals(['jquery', 'vuejs'], $style->getDependencies());

        $style = new Style('style_name', 'http://site.com');
        $this->assertFalse($style->hasDependencies());

        $style->with('jquery');
        $this->assertEquals(['jquery'], $style->getDependencies());

        $style->with(['jquery', 'vue']);
        $this->assertEquals(['jquery', 'vue'], $style->getDependencies());

        $this->assertTrue($style->hasDependencies());
    }
}