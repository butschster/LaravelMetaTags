<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Tests\TestCase;

class FaviconMetaTagsTest extends TestCase
{
    function test_favicon_can_be_set()
    {
        $this->assertHtmlableContains(
            '<link rel="icon" type="image/x-icon" href="http://example.com/favicon.ico">',
            $this->makeMetaTags()->setFavicon('http://example.com/favicon.ico')
        );
    }

    function test_favicon_can_have_attributes()
    {
        $this->assertHtmlableContains(
            '<link rel="icon" type="image/x-icon" href="http://example.com/favicon.ico" sizes="16x16">',
            $this->makeMetaTags()
                ->setFavicon('http://example.com/favicon.ico', [
                    'sizes' => '16x16'
                ])
        );
    }

    function test_convert_to_array()
    {
        $this->assertEquals([
            [
                'rel' => 'icon',
                'type' => 'image/x-icon',
                'href' => 'http://example.com/favicon.ico',
                'sizes' => '16x16',
                'tag' => 'link',
            ]
        ], $this->makeMetaTags()
            ->setFavicon('http://example.com/favicon.ico', [
                'sizes' => '16x16'
            ])->head()->toArray());
    }
}
