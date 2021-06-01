<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Viewport;
use Butschster\Head\Packages\Manager;
use Butschster\Tests\TestCase;
use Illuminate\Support\Facades\Session;

class MetaTest extends TestCase
{
    function test_class_can_be_initialized_with_default_values()
    {
        Session::shouldReceive('token')->andReturn('token');
        $manager = new Manager();

        $manager->create('jquery', function ($package) {
            $package->addScript('jquery.js', 'http://site.com/jquery.js', ['defer']);
        });

        $manager->create('vuejs', function ($package) {
            $package->addScript('vuejs.js', 'http://site.com/vuejs.js', ['defer']);
        });

        $config = $this->makeConfig();

        $config->shouldReceive('get')->andReturnUsing(function (string $key) {
            switch ($key) {
                case 'meta_tags.title.default':
                    return 'Default title';
                case 'meta_tags.title.separator':
                    return '-';
                case 'meta_tags.description.default':
                    return 'Default description';
                case 'meta_tags.keywords.default':
                    return ['keyword1', 'keyword2'];
                case 'meta_tags.charset':
                    return 'utf-8';
                case 'meta_tags.viewport':
                    return Viewport::RESPONSIVE;
                case 'meta_tags.robots':
                    return 'noindex';
                case 'meta_tags.csrf_token':
                    return true;
                case 'meta_tags.packages':
                    return ['jquery'];
            }

            return null;
        });

        $meta = $this->makeMetaTags($manager, $config);
        $meta->initialize();

        $this->assertHtmlableContains([
            '<title>Default title</title>',
            '<meta name="description" content="Default description">',
            '<meta name="keywords" content="keyword1, keyword2">',
            '<meta charset="utf-8">',
            '<meta name="viewport" content="width=device-width, initial-scale=1">',
            '<meta name="robots" content="noindex">',
            '<meta name="csrf-token" content="token">',
        ], $meta);

        $this->assertHtmlableContains([
            '<script src="http://site.com/jquery.js" defer></script>',
        ], $meta->footer());

        $this->assertHtmlableNotContains([
            '<script src="http://site.com/jquery.js" defer></script>',
        ], $meta);

        $this->assertHtmlableNotContains([
            '<script src="http://site.com/vuejs.js" defer></script>',
        ], $meta->footer());
    }

    function test_multiple_webmaster_tags_can_be_set()
    {
        $meta = $this->makeMetaTags()
            ->addWebmaster('google', 'long-hash-string')
            ->addWebmaster('yandex', 'long-hash-string');

        $this->assertHtmlableContains([
            '<meta name="yandex-verification" content="long-hash-string">',
            '<meta name="google-site-verification" content="long-hash-string">',
        ], $meta);
    }

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
            ->setNextHref('http://site.com?foo=bar&bar=baz')
            ->setPrevHref('http://site.com?foo=bar&bar=baz')
            ->setCanonical('http://site.com?foo=bar&bar=baz')
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
            '<link rel="next" href="http://site.com?foo=bar&bar=baz">',
            '<link rel="prev" href="http://site.com?foo=bar&bar=baz">',
            '<link rel="canonical" href="http://site.com?foo=bar&bar=baz">',
            '<link rel="alternate" hreflang="en" href="http://site.com/en">',
            '<link rel="alternate" hreflang="ru" href="http://site.com/ru">'
        ], $meta);
    }

    function test_converts_to_array()
    {
        $manager = new Manager();

        $manager->create('jquery', function ($package) {
            $package->addScript('jquery.js', 'http://site.com/jquery.js', ['defer']);
            $package->addStyle('bootstrap.css', 'http://site.com/bootstrap.css', ['async']);
        });

        $meta = $this->makeMetaTags($manager)
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

        $meta->includePackages('jquery');


        $this->assertEquals([
            'head' => [
                [
                    'tag' => 'title',
                    'content' => 'additional title | test title',
                ],
                [
                    'name' => 'description',
                    'content' => 'meta description',
                    'type' => 'tag',
                    'tag' => 'meta',
                ],
                [
                    'name' => 'keywords',
                    'content' => 'keyword 1, keyword 2',
                    'type' => 'tag',
                    'tag' => 'meta',
                ],
                [
                    'name' => 'robots',
                    'content' => 'no follow',
                    'type' => 'tag',
                    'tag' => 'meta',
                ],
                [
                    'rel' => 'next',
                    'href' => 'http://site.com',
                    'type' => 'tag',
                    'tag' => 'link',
                ],
                [
                    'rel' => 'prev',
                    'href' => 'http://site.com',
                    'type' => 'tag',
                    'tag' => 'link',
                ],
                [
                    'http-equiv' => 'Content-Type',
                    'content' => 'text/html; charset=utf-8',
                    'type' => 'tag',
                    'tag' => 'meta',
                ],
                [
                    'rel' => 'alternate',
                    'hreflang' => 'en',
                    'href' => 'http://site.com/en',
                    'type' => 'tag',
                    'tag' => 'link',
                ],
                [
                    'rel' => 'alternate',
                    'hreflang' => 'ru',
                    'href' => 'http://site.com/ru',
                    'type' => 'tag',
                    'tag' => 'link',
                ],
                [
                    'name' => 'viewport',
                    'content' => 'width=device-width, initial-scale=1',
                    'type' => 'tag',
                    'tag' => 'meta',
                ],
                [
                    'name' => 'og::title',
                    'content' => 'test og title',
                    'type' => 'tag',
                    'tag' => 'meta',
                ],
                [
                    'media' => 'all',
                    'type' => 'text/css',
                    'rel' => 'stylesheet',
                    'href' => 'http://site.com/bootstrap.css',
                    'tag' => 'link',
                    'async' => true,
                ]
            ],
            'footer' => [
                [
                    'src' => 'http://site.com/jquery.js',
                    'defer' => true,
                    'type' => 'tag',
                    'tag' => 'script',
                ]
            ]
        ], $meta->toArray());
    }
}
