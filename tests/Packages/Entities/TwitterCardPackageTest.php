<?php

namespace Butschster\Tests\Packages\Entities;

use Butschster\Head\Packages\Entities\TwitterCardPackage;
use Butschster\Tests\TestCase;

class TwitterCardPackageTest extends TestCase
{
    function test_a_card_can_have_type()
    {
        $card = new TwitterCardPackage('twitter');

        $this->assertInstanceOf(
            TwitterCardPackage::class,
            $card->setType(TwitterCardPackage::CARD_SUMMARY)
        );

        $this->assertStringContainsString(
            '<meta name="twitter:card" content="summary">',
            $card->toHtml()
        );
    }

    function test_a_card_can_have_site()
    {
        $card = new TwitterCardPackage('twitter');

        $this->assertInstanceOf(
            TwitterCardPackage::class,
            $card->setSite('@username')
        );

        $this->assertStringContainsString(
            '<meta name="twitter:site" content="@username">',
            $card->toHtml()
        );
    }

    function test_a_card_can_have_title()
    {
        $card = new TwitterCardPackage('twitter');

        $this->assertInstanceOf(
            TwitterCardPackage::class,
            $card->setTitle('Post title')
        );

        $this->assertStringContainsString(
            '<meta name="twitter:title" content="Post title">',
            $card->toHtml()
        );
    }

    function test_a_card_can_have_description()
    {
        $card = new TwitterCardPackage('twitter');

        $this->assertInstanceOf(
            TwitterCardPackage::class,
            $card->setDescription('View the album on Flickr.')
        );

        $this->assertStringContainsString(
            '<meta name="twitter:description" content="View the album on Flickr.">',
            $card->toHtml()
        );
    }

    function test_a_card_can_have_a_creator()
    {
        $card = new TwitterCardPackage('twitter');

        $this->assertInstanceOf(
            TwitterCardPackage::class,
            $card->setCreator('@username')
        );

        $this->assertStringContainsString(
            '<meta name="twitter:creator" content="@username">',
            $card->toHtml()
        );
    }

    function test_a_card_can_have_an_image()
    {
        $card = new TwitterCardPackage('twitter');

        $this->assertInstanceOf(
            TwitterCardPackage::class,
            $card->addImage('https://site.com')
        );

        $this->assertStringContainsString(
            '<meta name="twitter:image" content="https://site.com">',
            $card->toHtml()
        );
    }

    function test_custom_meta_tags_can_be_added()
    {
        $card = new TwitterCardPackage('twitter');
        $this->assertInstanceOf(
            TwitterCardPackage::class,
            $card->addMeta('url', 'https://site.com')
        );

        $this->assertStringContainsString(
            '<meta name="twitter:url" content="https://site.com">',
            $card->toHtml()
        );
    }

    function test_a_card_can_be_registered_as_a_meta_package()
    {
        $meta = $this->makeMetaTags()
            ->setDescription('Meta description')
            ->setTitle('Meta title');

        $card = new TwitterCardPackage('twitter');

        $card->addMeta('url', 'https://site.com')
            ->addImage('https://site.com')
            ->setCreator('@username')
            ->setDescription('View the album on Flickr.')
            ->setTitle('Post title')
            ->setSite('@username')
            ->setType(TwitterCardPackage::CARD_SUMMARY);

        $meta->registerPackage($card);

        $this->assertStringContainsString('<title>Meta title</title>', $meta->toHtml());
        $this->assertStringContainsString('<meta name="description" content="Meta description">', $meta->toHtml());
        $this->assertStringContainsString('<meta name="twitter:url" content="https://site.com">', $meta->toHtml());
        $this->assertStringContainsString('<meta name="twitter:image" content="https://site.com">', $meta->toHtml());
    }
}