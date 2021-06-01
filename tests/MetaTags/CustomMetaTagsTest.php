<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Entities\Tag;
use Butschster\Head\MetaTags\TagsCollection;
use Butschster\Tests\TestCase;
use Illuminate\Support\Collection;

class CustomMetaTagsTest extends TestCase
{
    function test_custom_meta_tag_can_be_set()
    {
        $meta = $this->makeMetaTags();

        $meta->addMeta('custom', [
            'name' => 'custom',
            'content' => 'test data'
        ]);

        $this->assertHtmlableEquals(
            '<meta name="custom" content="test data">',
            $meta->getTag('custom')
        );
    }

    function test_meta_tag_can_be_deleted_by_name()
    {
        $meta = $this->makeMetaTags();

        $meta->addMeta('test1', [
            'name' => 'custom',
            'content' => 'test data'
        ]);

        $meta->removeTag('test1');

        $this->assertNull(
            $meta->getTag('test1')
        );
    }

    function test_tags_collection_can_be_registered_with_placemenents_form_tags()
    {
        $meta = $this->makeMetaTags();

        $tag1 = Tag::meta(['name' => 'tag1']);
        $tag2 = Tag::meta(['name' => 'tag2']);

        $meta->registerTags(
            new TagsCollection([
                $tag1, $tag2->setPlacement('footer')
            ])
        );

        $this->assertHtmlableContains('<meta name="tag1">', $meta);
        $this->assertHtmlableNotContains('<meta name="tag2">', $meta);
        $this->assertHtmlableContains('<meta name="tag2">', $meta->placement('footer'));
    }

    function test_tags_collection_can_be_registered_with_custom_placement()
    {
        $meta = $this->makeMetaTags();

        $tag1 = Tag::meta(['name' => 'tag1']);
        $tag2 = Tag::meta(['name' => 'tag2']);

        $meta->registerTags(new TagsCollection([
            $tag1, $tag2->setPlacement('footer')
        ]), 'test');

        $this->assertHtmlableNotContains('<meta name="tag1">', $meta);
        $this->assertHtmlableNotContains('<meta name="tag2">', $meta);
        $this->assertHtmlableNotContains('<meta name="tag2">', $meta->placement('footer'));
        $this->assertHtmlableContains('<meta name="tag1">', $meta->placement('test'));
        $this->assertHtmlableContains('<meta name="tag2">', $meta->placement('test'));
    }

    function test_convert_to_array()
    {
        $meta = $this->makeMetaTags();

        $tag1 = Tag::meta(['name' => 'tag1']);
        $tag2 = Tag::meta(['name' => 'tag2']);

        $meta->registerTags(new TagsCollection([
            $tag1, $tag2->setPlacement('footer')
        ]), 'test');

        $this->assertEquals([
            [
                'name' => 'tag1',
                'type' => 'tag',
                'tag' => 'meta',
            ],
            [
                'name' => 'tag2',
                'type' => 'tag',
                'tag' => 'meta',
            ]
        ], $meta->placement('test')->toArray());
    }
}
