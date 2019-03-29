<?php

namespace Butschster\Tests\Packages\Entities;

use Butschster\Head\Packages\Entities\OpenGraphPackage;
use Butschster\Tests\TestCase;

class OpenGraphPackageTest extends TestCase
{
    function test_a_graph_can_have_type()
    {
        $graph = new OpenGraphPackage('facebook');

        $this->assertHtmlableEquals(
            '<meta name="og:type" content="website">',
            $graph->setType('website')
        );
    }

    function test_a_graph_can_have_site_name()
    {
        $graph = new OpenGraphPackage('facebook');

        $this->assertHtmlableContains(
            '<meta name="og:site_name" content="My awesome site">',
            $graph->setSiteName('My awesome site')
        );
    }

    function test_a_graph_can_have_title()
    {
        $graph = new OpenGraphPackage('facebook');

        $this->assertHtmlableContains(
            '<meta name="og:title" content="Post title">',
            $graph->setTitle('Post title')
        );
    }

    function test_a_graph_can_have_description()
    {
        $graph = new OpenGraphPackage('facebook');

        $this->assertHtmlableContains(
            '<meta name="og:description" content="View the album on Flickr.">',
            $graph->setDescription('View the album on Flickr.')
        );
    }

    function test_a_graph_can_have_an_image()
    {
        $graph = new OpenGraphPackage('facebook');

        $this->assertHtmlableContains(
            '<meta name="og:image" content="https://site.com">',
            $graph->addImage('https://site.com')
        );
    }
    
    function test_an_image_can_have_properties()
    {
        $graph = new OpenGraphPackage('facebook');
        $graph->addImage('http://site.com', [
            'secure_url' => 'https://site.com',
            'type' => 'image/png'
        ]);

        $this->assertHtmlableContains([
            '<meta name="og:image" content="http://site.com">',
            '<meta name="og:image:secure_url" content="https://site.com">',
            '<meta name="og:image:type" content="image/png">'
        ], $graph);
    }

    function test_a_graph_can_have_a_video()
    {
        $graph = new OpenGraphPackage('facebook');

        $this->assertHtmlableContains(
            '<meta name="og:video" content="https://site.com">',
            $graph->addVideo('https://site.com')
        );
    }

    function test_a_video_can_have_properties()
    {
        $graph = new OpenGraphPackage('facebook');
        $graph->addVideo('http://site.com', [
            'secure_url' => 'https://site.com',
            'type' => 'application/x-shockwave-flash'
        ]);

        $this->assertHtmlableContains([
            '<meta name="og:video" content="http://site.com">',
            '<meta name="og:video:secure_url" content="https://site.com">',
            '<meta name="og:video:type" content="application/x-shockwave-flash">',
        ], $graph);
    }

    function test_a_graph_can_have_an_url()
    {
        $graph = new OpenGraphPackage('facebook');

        $this->assertHtmlableContains(
            '<meta name="og:url" content="https://site.com">',
            $graph->setUrl('https://site.com')
        );
    }

    function test_a_graph_can_have_a_locale()
    {
        $graph = new OpenGraphPackage('facebook');

        $this->assertHtmlableContains(
            '<meta name="og:locale" content="en_US">',
            $graph->setLocale('en_US')
        );

        $graph->addAlternateLocale('en_US', 'ru_RU');

        $this->assertHtmlableContains([
            '<meta name="og:locale" content="en_US">',
            '<meta name="og:locale:alternate" content="en_US">',
            '<meta name="og:locale:alternate" content="ru_RU">',
        ], $graph);
    }

    function test_custom_meta_tags_can_be_added()
    {
        $graph = new OpenGraphPackage('facebook');

        $this->assertHtmlableContains(
            '<meta name="og:url" content="https://site.com">',
            $graph->addMeta('url', 'https://site.com')
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

        $this->assertHtmlableContains([
            '<title>Meta title</title>',
            '<meta name="description" content="Meta description">',
            '<meta name="og:description" content="View the album on Flickr.">',
            '<meta name="og:url" content="https://site.com">',
            '<meta name="og:image" content="https://site.com">'
        ], $meta);
    }
}