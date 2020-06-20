<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Tests\TestCase;

class CustomLinkMetaTagsTest extends TestCase
{
    function test_custom_meta_tag_can_be_set()
    {
        $this->assertHtmlableEquals(
            '<link rel="canonical" href="http://site.com">',
            $this->makeMetaTags()->addLink('canonical', [
                'href' => 'http://site.com',
            ])->getTag('canonical')
        );
    }
}