<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Tests\TestCase;

class KeywordsMetaTagsTest extends TestCase
{
    function test_keywords_from_array_can_be_set()
    {
        $this->assertHtmlableEquals(
            '<meta name="keywords" content="keyword1, keyword2">',
            $this->makeMetaTags()
                ->setKeywords(['keyword1', 'keyword2'])
                ->getKeywords()
        );
    }

    function test_keywords_from_string_can_be_set()
    {
        $this->assertHtmlableEquals(
            '<meta name="keywords" content="keyword1, keyword2">',
            $this->makeMetaTags()
                ->setKeywords('keyword1, keyword2')
                ->getKeywords()
        );
    }

    function test_set_keywords_method_should_be_fluent()
    {
        $meta = $this->makeMetaTags();

        $this->assertEquals($meta, $meta->setKeywords('keyword1'));
    }

    function test_keywords_should_be_null_if_not_set()
    {
        $this->assertNull(
            $this->makeMetaTags()->getKeywords()
        );
    }

    function test_keywords_string_should_be_cleaned()
    {
        $meta = $this->makeMetaTags()
            ->setKeywords('<h5>keyword1, keyword2</h5>');

        $this->assertHtmlableEquals(
            '<meta name="keywords" content="keyword1, keyword2">',
            $meta->getKeywords()
        );

        $meta->setKeywords(['<h5>keyword1</h5>', '<h5>keyword2</h5>']);
        $this->assertHtmlableEquals(
            '<meta name="keywords" content="keyword1, keyword2">',
            $meta->getKeywords()
        );
    }
}