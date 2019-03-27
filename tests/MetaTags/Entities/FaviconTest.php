<?php

namespace Butschster\Tests\MetaTags\Entities;

use Butschster\Head\MetaTags\Entities\Favicon;
use Butschster\Tests\TestCase;

class FaviconTest extends TestCase
{
    function test_it_can_be_rendered_to_html()
    {
        $favicon = new Favicon('http://site.com/favicon.ico');

        $this->assertEquals(
            '<link rel="icon" type="image/x-icon" href="http://site.com/favicon.ico" />',
            $favicon->toHtml()
        );
    }

    function test_in_can_change_type_based_on_file_extension()
    {
        $favicon = new Favicon('http://site.com/favicon.png');

        $this->assertEquals(
            '<link rel="icon" type="image/png" href="http://site.com/favicon.png" />',
            $favicon->toHtml()
        );

        $favicon = new Favicon('http://site.com/favicon.gif');

        $this->assertEquals(
            '<link rel="icon" type="image/gif" href="http://site.com/favicon.gif" />',
            $favicon->toHtml()
        );

        $favicon = new Favicon('http://site.com/favicon.svg');

        $this->assertEquals(
            '<link rel="icon" type="image/svg+xml" href="http://site.com/favicon.svg" />',
            $favicon->toHtml()
        );
    }

    function test_it_can_have_custom_attributes()
    {
        $favicon = new Favicon('http://site.com/favicon.png', [
            'sizes' => '16x16'
        ]);

        $this->assertEquals(
            '<link rel="icon" type="image/png" href="http://site.com/favicon.png" sizes="16x16" />',
            $favicon->toHtml()
        );
    }
}