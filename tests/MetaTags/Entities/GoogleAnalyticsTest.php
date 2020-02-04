<?php

namespace Butschster\Tests\MetaTags\Entities;

use Butschster\Head\MetaTags\Entities\GoogleAnalytics;
use Butschster\Tests\TestCase;

class GoogleAnalyticsTest extends TestCase
{
    function test_it_can_be_created()
    {
        $tag = new GoogleAnalytics('UA-12345678-1');

        $this->assertEquals(<<<TAG
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-12345678-1', 'auto');
    ga('send', 'pageview');
</script>
TAG
            , $tag->toHtml());
    }

    function test_it_can_be_add_to_meta_class()
    {
        $meta = $this->makeMetaTags();
        $meta->addTag('google.analytics', new GoogleAnalytics('UA-12345678-1'));

        $this->assertHtmlableContains([
            '<script>',
            'https://www.google-analytics.com/analytics.js',
            "ga('create', 'UA-12345678-1', 'auto');",
            '</script>',
        ], $meta->footer());

        $this->assertHtmlableNotContains([
            "ga('create', 'UA-12345678-1', 'auto');",
        ], $meta->head());
    }
}
