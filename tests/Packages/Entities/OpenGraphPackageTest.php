<?php

namespace Butschster\Tests\Packages\Entities;

use Butschster\Head\Packages\Entities\OpenGraphPackage;
use Butschster\Tests\TestCase;

class OpenGraphPackageTest extends TestCase
{
    function test_a_graph_can_have_type()
    {
        $graph = new OpenGraphPackage('facebook');

        $this->assertInstanceOf(
            OpenGraphPackage::class,
            $graph->setType('website')
        );

        $this->assertStringContainsString(
            '<meta name="og:type" content="website">',
            $graph->toHtml()
        );
    }

    function test_a_graph_can_have_site_name()
    {
        $graph = new OpenGraphPackage('facebook');

        $this->assertInstanceOf(
            OpenGraphPackage::class,
            $graph->setSiteName('My awesome site')
        );

        $this->assertStringContainsString(
            '<meta name="og:site_name" content="My awesome site">',
            $graph->toHtml()
        );
    }

    function test_a_graph_can_have_title()
    {
        $graph = new OpenGraphPackage('facebook');

        $this->assertInstanceOf(
            OpenGraphPackage::class,
            $graph->setTitle('Post title')
        );

        $this->assertStringContainsString(
            '<meta name="og:title" content="Post title">',
            $graph->toHtml()
        );
    }

    function test_a_graph_can_have_description()
    {
        $graph = new OpenGraphPackage('facebook');

        $this->assertInstanceOf(
            OpenGraphPackage::class,
            $graph->setDescription('View the album on Flickr.')
        );

        $this->assertStringContainsString(
            '<meta name="og:description" content="View the album on Flickr.">',
            $graph->toHtml()
        );
    }

    function test_a_graph_can_have_an_image()
    {
        $graph = new OpenGraphPackage('facebook');

        $this->assertInstanceOf(
            OpenGraphPackage::class,
            $graph->addImage('https://site.com')
        );

        $this->assertStringContainsString(
            '<meta name="og:image" content="https://site.com">',
            $graph->toHtml()
        );
    }
    
    function test_an_image_can_have_properties()
    {
        $graph = new OpenGraphPackage('facebook');
        $graph->addImage('http://site.com', [
            'secure_url' => 'https://site.com',
            'type' => 'image/png'
        ]);

        $this->assertStringContainsString(
            '<meta name="og:image" content="http://site.com">',
            $graph->toHtml()
        );

        $this->assertStringContainsString(
            '<meta name="og:image:secure_url" content="https://site.com">',
            $graph->toHtml()
        );

        $this->assertStringContainsString(
            '<meta name="og:image:type" content="image/png">',
            $graph->toHtml()
        );
    }

    function test_a_graph_can_have_a_video()
    {
        $graph = new OpenGraphPackage('facebook');

        $this->assertInstanceOf(
            OpenGraphPackage::class,
            $graph->addVideo('https://site.com')
        );

        $this->assertStringContainsString(
            '<meta name="og:video" content="https://site.com">',
            $graph->toHtml()
        );
    }

    function test_a_video_can_have_properties()
    {
        $graph = new OpenGraphPackage('facebook');
        $graph->addVideo('http://site.com', [
            'secure_url' => 'https://site.com',
            'type' => 'application/x-shockwave-flash'
        ]);

        $this->assertStringContainsString(
            '<meta name="og:video" content="http://site.com">',
            $graph->toHtml()
        );

        $this->assertStringContainsString(
            '<meta name="og:video:secure_url" content="https://site.com">',
            $graph->toHtml()
        );

        $this->assertStringContainsString(
            '<meta name="og:video:type" content="application/x-shockwave-flash">',
            $graph->toHtml()
        );
    }

    function test_a_graph_can_have_an_url()
    {
        $graph = new OpenGraphPackage('facebook');

        $this->assertInstanceOf(
            OpenGraphPackage::class,
            $graph->setUrl('https://site.com')
        );

        $this->assertStringContainsString(
            '<meta name="og:url" content="https://site.com">',
            $graph->toHtml()
        );
    }

    function test_a_graph_can_have_a_locale()
    {
        $graph = new OpenGraphPackage('facebook');

        $this->assertInstanceOf(
            OpenGraphPackage::class,
            $graph->setLocale('en_US')
        );

        $this->assertStringContainsString(
            '<meta name="og:locale" content="en_US">',
            $graph->toHtml()
        );

        $this->assertInstanceOf(
            OpenGraphPackage::class,
            $graph->addAlternateLocale('en_US', 'ru_RU')
        );

        $this->assertStringContainsString(
            '<meta name="og:locale" content="en_US">',
            $graph->toHtml()
        );
        $this->assertStringContainsString(
            '<meta name="og:locale:alternate" content="en_US">',
            $graph->toHtml()
        );
        $this->assertStringContainsString(
            '<meta name="og:locale:alternate" content="ru_RU">',
            $graph->toHtml()
        );
    }

    function test_custom_meta_tags_can_be_added()
    {
        $graph = new OpenGraphPackage('facebook');
        $this->assertInstanceOf(
            OpenGraphPackage::class,
            $graph->addMeta('url', 'https://site.com')
        );

        $this->assertStringContainsString(
            '<meta name="og:url" content="https://site.com">',
            $graph->toHtml()
        );
    }

    function test_a_graph_can_be_registered_as_a_meta_package()
    {
        $meta = $this->makeMetaTags()
            ->setDescription('Meta description')
            ->setTitle('Meta title');

        $graph = new OpenGraphPackage('facebook');

        $graph->addMeta('url', 'https://site.com')
            ->addImage('https://site.com')
            ->setDescription('View the album on Flickr.')
            ->setTitle('Post title');

        $meta->registerPackage($graph);

        $this->assertStringContainsString('<title>Meta title</title>', $meta->toHtml());
        $this->assertStringContainsString('<meta name="description" content="Meta description">', $meta->toHtml());
        $this->assertStringContainsString('<meta name="og:description" content="View the album on Flickr.">', $meta->toHtml());
        $this->assertStringContainsString('<meta name="og:url" content="https://site.com">', $meta->toHtml());
        $this->assertStringContainsString('<meta name="og:image" content="https://site.com">', $meta->toHtml());
    }
}