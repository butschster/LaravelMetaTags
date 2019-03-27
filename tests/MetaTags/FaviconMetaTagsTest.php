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

        $meta = $this->makeMetaTags()
            ->setFavicon('http://example.com/favicon.png');

        $this->assertStringContainsString(
            '<link rel="icon" type="image/png" href="http://example.com/favicon.png" />',
            $meta->toHtml()
        );

        $meta = $this->makeMetaTags()
            ->setFavicon('http://example.com/favicon.gif');

        $this->assertStringContainsString(
            '<link rel="icon" type="image/gif" href="http://example.com/favicon.gif" />',
            $meta->toHtml()
        );

        $meta = $this->makeMetaTags()
            ->setFavicon('http://example.com/favicon.svg');

        $this->assertStringContainsString(
            '<link rel="icon" type="image/svg+xml" href="http://example.com/favicon.svg" />',
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