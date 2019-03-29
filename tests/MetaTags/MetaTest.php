<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Tests\TestCase;
use Illuminate\Support\Facades\Session;

class MetaTest extends TestCase
{
    function test_charset_can_be_set()
    {
        $meta = $this->makeMetaTags()
            ->setCharset();

        $this->assertStringContainsString(
            '<meta charset="utf-8">',
            $meta->getCharset()->toHtml()
        );

        $meta->setCharset('ISO-8859-1');

        $this->assertStringContainsString(
            '<meta charset="ISO-8859-1">',
            $meta->getCharset()->toHtml()
        );
    }

    function test_csrf_token_can_be_add()
    {
        Session::shouldReceive('token')->once()->andReturn('token');

        $meta = $this->makeMetaTags();

        $meta->addCsrfToken();

        $this->assertStringContainsString(
            '<meta name="csrf-token" content="token">',
            $meta->toHtml()
        );
    }

    function test_it_can_be_reset()
    {
        $meta = $this->makeMetaTags()
            ->setTitle('test title')
            ->prependTitle('additional title')
            ->setDescription('meta description')
            ->setKeywords(['keyword 1', 'keyword 2'])
            ->setRobots('no follow')
            ->setNextHref('http://site.com')
            ->setPrevHref('http://site.com')
            ->setContentType('<h5>text/html</h5>')
            ->setHrefLang('en', 'http://site.com/en')
            ->setHrefLang('ru', 'http://site.com/ru')
            ->setViewport('width=device-width, initial-scale=1')
            ->addMeta('og::title', [
                'content' => 'test og title'
            ]);

        $meta->reset();

        $this->assertNull($meta->getPrevHref());
        $this->assertNull($meta->getNextHref());
        $this->assertNull($meta->getDescription());
        $this->assertNull($meta->getKeywords());
        $this->assertNull($meta->getRobots());
        $this->assertNull($meta->getCanonical());
        $this->assertNull($meta->getContentType());
        $this->assertNull($meta->getViewport());
        $this->assertNull($meta->getHrefLang('en'));
        $this->assertNull($meta->getHrefLang('ru'));
        $this->assertNull($meta->getTag('og::title'));
    }

    function test_meta_information_for_head_can_be_rendered()
    {
        $tag = $this->makeTag();
        $tag->shouldReceive('getPlacement')->once()->andReturn('footer');

        $meta = $this->makeMetaTags()
            ->setTitle('test title')
            ->prependTitle('additional title')
            ->setDescription('meta description')
            ->setKeywords(['keyword 1', 'keyword 2'])
            ->setRobots('no follow')
            ->setNextHref('http://site.com')
            ->setPrevHref('http://site.com')
            ->setCanonical('http://site.com')
            ->setHrefLang('en', 'http://site.com/en')
            ->setHrefLang('ru', 'http://site.com/ru')
            ->setContentType('<h5>text/html</h5>')
            ->setViewport('width=device-width, initial-scale=1')
            ->addMeta('og::title', [
                'content' => 'test og title'
            ])
            ->addTag('footer_tag', $tag);

        $this->assertHtmlableNotContains('<tag></tag>', $meta);

        $this->assertHtmlableContains([
            '<meta name="viewport" content="width=device-width, initial-scale=1">',
            '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">',
            '<title>additional title | test title</title>',
            '<meta name="description" content="meta description">',
            '<meta name="keywords" content="keyword 1, keyword 2">',
            '<meta name="robots" content="no follow">',
            '<meta name="og::title" content="test og title">',
            '<link rel="next" href="http://site.com" />',
            '<link rel="prev" href="http://site.com" />',
            '<link rel="canonical" href="http://site.com" />',
            '<link rel="alternate" hreflang="en" href="http://site.com/en" />',
            '<link rel="alternate" hreflang="ru" href="http://site.com/ru" />'
        ], $meta);
    }
}