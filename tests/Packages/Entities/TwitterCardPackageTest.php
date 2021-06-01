<?php

namespace Butschster\Tests\Packages\Entities;

use Butschster\Head\Packages\Entities\TwitterCardPackage;
use Butschster\Tests\TestCase;

class TwitterCardPackageTest extends TestCase
{
    function test_a_card_can_have_type()
    {
        $card = new TwitterCardPackage('twitter');

        $this->assertHtmlableContains(
            '<meta name="twitter:card" content="summary">',
            $card->setType(TwitterCardPackage::CARD_SUMMARY)
        );
    }

    function test_a_card_can_have_site()
    {
        $card = new TwitterCardPackage('twitter');

        $this->assertHtmlableContains(
            '<meta name="twitter:site" content="@username">',
            $card->setSite('@username')
        );
    }

    function test_a_card_can_have_title()
    {
        $card = new TwitterCardPackage('twitter');

        $this->assertHtmlableContains(
            '<meta name="twitter:title" content="Post title">',
            $card->setTitle('Post title')
        );
    }

    function test_a_card_can_have_description()
    {
        $card = new TwitterCardPackage('twitter');

        $this->assertHtmlableContains(
            '<meta name="twitter:description" content="View the album on Flickr.">',
            $card->setDescription('View the album on Flickr.')
        );
    }

    function test_a_card_can_have_a_creator()
    {
        $card = new TwitterCardPackage('twitter');

        $this->assertHtmlableContains(
            '<meta name="twitter:creator" content="@username">',
            $card->setCreator('@username')
        );
    }

    function test_a_card_can_have_an_image()
    {
        $card = new TwitterCardPackage('twitter');

        $this->assertHtmlableContains(
            '<meta name="twitter:image" content="https://site.com">',
            $card->addImage('https://site.com')
        );
    }

    function test_custom_meta_tags_can_be_added()
    {
        $card = new TwitterCardPackage('twitter');

        $this->assertHtmlableContains(
            '<meta name="twitter:url" content="https://site.com">',
            $card->addMeta('url', 'https://site.com')
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

        $this->assertHtmlableContains([
            '<title>Meta title</title>',
            '<meta name="description" content="Meta description">',
            '<meta name="twitter:url" content="https://site.com">',
            '<meta name="twitter:image" content="https://site.com">'
        ], $meta);
    }

    function test_converts_to_array()
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

        $this->assertEquals([
            [
                'name' => 'description',
                'content' => 'Meta description',
                'type' => 'tag',
                'tag' => 'meta',
            ],
            [
                'tag' => 'title',
                'content' => 'Meta title',
            ],
            [
                'name' => 'twitter:url',
                'content' => 'https://site.com',
                'type' => 'tag',
                'tag' => 'meta',
            ],
            [
                'name' => 'twitter:image',
                'content' => 'https://site.com',
                'type' => 'tag',
                'tag' => 'meta',
            ],
            [
                'name' => 'twitter:creator',
                'content' => '@username',
                'type' => 'tag',
                'tag' => 'meta',
            ],
            [
                'name' => 'twitter:description',
                'content' => 'View the album on Flickr.',
                'type' => 'tag',
                'tag' => 'meta',
            ],
            [
                'name' => 'twitter:title',
                'content' => 'Post title',
                'type' => 'tag',
                'tag' => 'meta',
            ],
            [
                'name' => 'twitter:site',
                'content' => '@username',
                'type' => 'tag',
                'tag' => 'meta',
            ],
            [
                'name' => 'twitter:card',
                'content' => 'summary',
                'type' => 'tag',
                'tag' => 'meta',
            ],
        ], $meta->head()->toArray());
    }
}
