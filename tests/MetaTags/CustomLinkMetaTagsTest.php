<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Tests\TestCase;

class CustomLinkMetaTagsTest extends TestCase
{
    function test_custom_meta_tag_can_be_set()
    {
        $meta = $this->makeMetaTags();

        $meta->addLink('canonical', [
            'href' => 'http://site.com',
        ]);

        $this->assertEquals(
            '<link rel="canonical" href="http://site.com" />',
            $meta->getMeta('canonical')->toHtml()
        );
    }
}