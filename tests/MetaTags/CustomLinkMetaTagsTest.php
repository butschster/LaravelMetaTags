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

    function test_convert_to_array()
    {
        $meta = $this->makeMetaTags();

        $this->assertEquals([
            'type' => 'tag',
            'tag' => 'link',
            'rel' => 'canonical',
            'href' => 'http://site.com',
        ], $meta->setContentType('text/html', 'ISO-8859-1')->addLink('canonical', [
            'href' => 'http://site.com',
        ])->getTag('canonical')->toArray());
    }
}
