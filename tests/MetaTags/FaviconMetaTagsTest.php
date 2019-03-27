<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Tests\TestCase;

class FaviconMetaTagsTest extends TestCase
{
    function test_favicon_can_be_set()
    {
        $meta = $this->makeMetaTags()
            ->setFavicon('http://example.com/favicon.ico');

        $this->assertStringContainsString(
            '<link rel="icon" type="image/x-icon" href="http://example.com/favicon.ico" />',
            $meta->toHtml()
        );
    }

    function test_favicon_can_have_attributes() {
        $meta = $this->makeMetaTags()
            ->setFavicon('http://example.com/favicon.ico', [
                'sizes' => '16x16'
            ]);

        $this->assertStringContainsString(
            '<link rel="icon" type="image/x-icon" href="http://example.com/favicon.ico" sizes="16x16" />',
            $meta->toHtml()
        );
    }
}