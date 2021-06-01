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
                    'type' => 'tag',
                    'tag' => 'meta',
                    'hid' => 'description',
                ],
                [
                    'name' => 'keywords',
                    'content' => 'keyword 1, keyword 2',
                    'type' => 'tag',
                    'tag' => 'meta',
                    'hid' => 'keywords',
                ],
                [
                    'name' => 'robots',
                    'content' => 'no follow',
                    'type' => 'tag',
                    'tag' => 'meta',
                    'hid' => 'robots',
                ],
                [
                    'http-equiv' => 'Content-Type',
                    'content' => 'text/html; charset=utf-8',
                    'type' => 'tag',
                    'tag' => 'meta',
                    'hid' => '2e3efde431b45a5fe05766b501f069c3'
                ],
                [
                    'name' => 'viewport',
                    'content' => 'width=device-width, initial-scale=1',
                    'type' => 'tag',
                    'tag' => 'meta',
                    'hid' => 'viewport',
                ],
                [
                    'name' => 'og::title',
                    'content' => 'test og title',
                    'type' => 'tag',
                    'tag' => 'meta',
                    'hid' => 'og::title',
                ],
            ],
            'link' => [
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
                    'media' => 'all',
                    'type' => 'text/css',
                    'rel' => 'stylesheet',
                    'href' => 'http://site.com/bootstrap.css',
                    'async' => true,
                    'tag' => 'link',
                ]
            ],
            'script' => [
                [
                    'src' => 'http://site.com/jquery.js',
                    'defer' => true,
                    'type' => 'tag',
                    'tag' => 'script',
                ]
            ],
        ], $hydrator->hydrate($meta));
    }
}
