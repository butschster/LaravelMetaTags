<?php
declare(strict_types=1);

namespace Butschster\Tests\Hydrator;

use Butschster\Head\Hydrator\VueMetaHydrator;
use Butschster\Head\Packages\Manager;
use Butschster\Tests\TestCase;

class VueMetaHydratorTest extends TestCase
{
    function test_hydrate()
    {
        $manager = new Manager();

        $manager->create('jquery', function ($package) {
            $package->addScript('jquery.js', 'http://site.com/jquery.js', ['defer'], 'head');
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

        $hydrator = new VueMetaHydrator();

        $this->assertEquals([
            'title' => 'additional title | test title',
            'meta' => [
                [
                    'name' => 'description',
                    'content' => 'meta description',
                    'hid' => 'description',
                ],
                [
                    'name' => 'keywords',
                    'content' => 'keyword 1, keyword 2',
                    'hid' => 'keywords',
                ],
                [
                    'name' => 'robots',
                    'content' => 'no follow',
                    'hid' => 'robots',
                ],
                [
                    'http-equiv' => 'Content-Type',
                    'content' => 'text/html; charset=utf-8',
                    'hid' => '3fe512a378a25993c5c0cba66099f2b4'
                ],
                [
                    'name' => 'viewport',
                    'content' => 'width=device-width, initial-scale=1',
                    'hid' => 'viewport',
                ],
                [
                    'name' => 'og::title',
                    'content' => 'test og title',
                    'hid' => 'og::title',
                ],
            ],
            'link' => [
                [
                    'rel' => 'next',
                    'href' => 'http://site.com',
                ],
                [
                    'rel' => 'prev',
                    'href' => 'http://site.com',
                ],
                [
                    'rel' => 'alternate',
                    'hreflang' => 'en',
                    'href' => 'http://site.com/en',
                ],
                [
                    'rel' => 'alternate',
                    'hreflang' => 'ru',
                    'href' => 'http://site.com/ru',
                ],
                [
                    'media' => 'all',
                    'rel' => 'stylesheet',
                    'href' => 'http://site.com/bootstrap.css',
                    'async' => true,
                ]
            ],
            'script' => [
                [
                    'src' => 'http://site.com/jquery.js',
                    'defer' => true,
                ]
            ],
        ], $hydrator->hydrate($meta));
    }
}
