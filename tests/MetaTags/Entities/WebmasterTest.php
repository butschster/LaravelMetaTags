<?php

namespace Butschster\Tests\MetaTags\Entities;

use Butschster\Head\MetaTags\Entities\Webmaster;
use Butschster\Tests\TestCase;
use InvalidArgumentException;

class WebmasterTest extends TestCase
{
    function test_google_webmaster_can_be_set()
    {
        $tag = new Webmaster(
            Webmaster::GOOGLE, 'long-hash-string'
        );

        $this->assertHtmlableEquals(
            '<meta name="google-site-verification" content="long-hash-string">',
            $tag
        );
    }

    function test_bing_webmaster_can_be_set()
    {
        $tag = new Webmaster(
            Webmaster::BING, 'long-hash-string'
        );

        $this->assertHtmlableEquals(
            '<meta name="msvalidate.01" content="long-hash-string">',
            $tag
        );
    }

    function test_alexa_webmaster_can_be_set()
    {
        $tag = new Webmaster(
            Webmaster::ALEXA, 'long-hash-string'
        );

        $this->assertHtmlableEquals(
            '<meta name="alexaVerifyID" content="long-hash-string">',
            $tag
        );
    }

    function test_pinterest_webmaster_can_be_set()
    {
        $tag = new Webmaster(
            Webmaster::PINTEREST, 'long-hash-string'
        );

        $this->assertHtmlableEquals(
            '<meta name="p:domain_verify" content="long-hash-string">',
            $tag
        );
    }

    function test_yandex_webmaster_can_be_set()
    {
        $tag = new Webmaster(
            Webmaster::YANDEX, 'long-hash-string'
        );

        $this->assertHtmlableEquals(
            '<meta name="yandex-verification" content="long-hash-string">',
            $tag
        );
    }

    function test_facebook_webmaster_can_be_set()
    {
        $tag = new Webmaster(
            Webmaster::FACEBOOK, 'long-hash-string'
        );

        $this->assertHtmlableEquals(
            '<meta name="facebook-domain-verification" content="long-hash-string">',
            $tag
        );
    }

    function test_an_exception_should_be_thrown_if_service_is_not_suppoerted()
    {
        $this->expectException(InvalidArgumentException::class);
        $tag = new Webmaster(
            'not_supported', 'long-hash-string'
        );
    }
}
