<?php

namespace Butschster\Tests\MetaTags\Entities;

use Butschster\Head\MetaTags\Entities\Script;
use Butschster\Head\MetaTags\Entities\Style;
use Butschster\Tests\TestCase;

class StyleTest extends TestCase
{
    function test_get_name()
    {
        $this->assertEquals('style_name', (new Style('style_name', 'http://site.com', [
            'type' => 'text/test',
            'media' => 'test',
            'rel' => 'css'
        ]))->getName());
    }

    function test_get_src()
    {
        $this->assertEquals('http://site.com', (new Style('style_name', 'http://site.com', [
            'type' => 'text/test',
            'media' => 'test',
            'rel' => 'css'
        ]))->getSrc());
    }

    function test_it_can_be_created()
    {
        $this->assertHtmlableEquals(
            '<link media="test" type="text/test" rel="css" href="http://site.com">',
            new Style('style_name', 'http://site.com', [
                'type' => 'text/test',
                'media' => 'test',
                'rel' => 'css'
            ])
        );
    }

    function test_if_media_attribute_not_set_use_default_value()
    {
        $this->assertHtmlableEquals(
            '<link media="all" type="text/test" rel="css" href="http://site.com">',
            new Style('style_name', 'http://site.com', [
                'type' => 'text/test',
                'rel' => 'css'
            ])
        );
    }

    function test_if_type_attribute_not_set_use_default_value()
    {
        $this->assertHtmlableEquals(
            '<link media="all" type="text/css" rel="css" href="http://site.com">',
            new Style('style_name', 'http://site.com', [
                'rel' => 'css'
            ])
        );
    }

    function test_if_rek_attribute_not_set_use_default_value()
    {
        $this->assertHtmlableEquals(
            '<link media="all" type="text/css" rel="stylesheet" href="http://site.com">',
            new Style('style_name', 'http://site.com')
        );
    }
}
