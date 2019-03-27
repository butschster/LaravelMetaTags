<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Tests\TestCase;

class HrefLangMetaTagsTest extends TestCase
{
    function test_hreflang_can_be_set()
    {
        $meta = $this->makeMetaTags();

        $meta->setHrefLang('en', 'http://site.com');
        $meta->setHrefLang('ru', 'http://site.com/ru');

        $this->assertEquals(
            '<link rel="alternate" hreflang="en" href="http://site.com" />',
            $meta->getHrefLang('en')->toHtml()
        );

        $this->assertEquals(
            '<link rel="alternate" hreflang="ru" href="http://site.com/ru" />',
            $meta->getHrefLang('ru')->toHtml()
        );
    }

    function test_set_hreflang_method_should_be_fluent()
    {
        $meta = $this->makeMetaTags();

        $this->assertEquals(
            $meta,
            $meta->setHrefLang('en', 'http://site.com')
        );
    }

    function test_hreflang_should_be_null_if_not_set()
    {
        $meta = $this->makeMetaTags();

        $this->assertNull($meta->getHrefLang('en'));
    }
}