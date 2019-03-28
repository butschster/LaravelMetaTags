<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Entities\Tag;
use Butschster\Head\MetaTags\TagsCollection;
use Butschster\Tests\TestCase;

class CustomMetaTagsTest extends TestCase
{
    function test_custom_meta_tag_can_be_set()
    {
        $meta = $this->makeMetaTags();

        $meta->addMeta('custom', [
            'name' => 'custom',
            'content' => 'test data'
        ]);

        $this->assertEquals(
            '<meta name="custom" content="test data">',
            $meta->getTag('custom')->toHtml()
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

        $tag1 = new Tag('meta', ['name' => 'tag1']);
        $tag2 = new Tag('meta', ['name' => 'tag2']);
        $tag2->setPlacement('footer');

        $tags = new TagsCollection([
            $tag1, $tag2
        ]);

        $meta->registerTags($tags);

        $this->assertStringContainsString(
            '<meta name="tag1">',
            $meta->toHtml()
        );

        $this->assertStringNotContainsString(
            '<meta name="tag2">',
            $meta->toHtml()
        );

        $this->assertStringContainsString(
            '<meta name="tag2">',
            $meta->placement('footer')->toHtml()
        );
    }

    function test_tags_collection_can_be_registered_with_custom_placement()
    {
        $meta = $this->makeMetaTags();

        $tag1 = new Tag('meta', ['name' => 'tag1']);
        $tag2 = new Tag('meta', ['name' => 'tag2']);
        $tag2->setPlacement('footer');

        $tags = new TagsCollection([
            $tag1, $tag2
        ]);

        $meta->registerTags($tags, 'test');

        $this->assertStringNotContainsString(
            '<meta name="tag1">',
            $meta->toHtml()
        );

        $this->assertStringNotContainsString(
            '<meta name="tag2">',
            $meta->toHtml()
        );

        $this->assertStringNotContainsString(
            '<meta name="tag2">',
            $meta->placement('footer')->toHtml()
        );

        $this->assertStringContainsString(
            '<meta name="tag1">',
            $meta->placement('test')->toHtml()
        );
        $this->assertStringContainsString(
            '<meta name="tag2">',
            $meta->placement('test')->toHtml()
        );
    }
}