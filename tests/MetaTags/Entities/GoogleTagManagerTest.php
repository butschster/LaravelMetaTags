<?php

namespace Butschster\Tests\MetaTags\Entities;

use Butschster\Head\MetaTags\Entities\GoogleTagManager;
use Butschster\Tests\TestCase;

class GoogleTagManagerTest extends TestCase
{
    function test_it_can_be_created()
    {
        $tag = new GoogleTagManager('UA-12345678-1');

        $this->assertHtmlableContains([
            '<script async src="https://www.googletagmanager.com/gtag/js?id=UA-12345678-1"></script>',
            "gtag('config', 'UA-12345678-1');",
            '</script>',
        ], $tag);
    }

    function test_it_can_be_add_to_meta_class()
    {
        $meta = $this->makeMetaTags();
        $meta->addTag('google.analytics', new GoogleTagManager('UA-12345678-1'));

        $this->assertHtmlableContains([
            '<script async src="https://www.googletagmanager.com/gtag/js?id=UA-12345678-1"></script>',
            "gtag('config', 'UA-12345678-1');",
            '</script>',
        ], $meta->head());

        $this->assertHtmlableNotContains([
            "gtag('config', 'UA-12345678-1');",
        ], $meta->footer());
    }
}
