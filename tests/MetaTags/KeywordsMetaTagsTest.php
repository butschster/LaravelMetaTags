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

    function test_keywords_from_string_can_be_null()
    {
        $this->assertHtmlableEquals(
            '<meta name="keywords" content="">',
            $this->makeMetaTags()->setKeywords(null)->getKeywords()
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

    function test_it_can_support_utf8()
    {
        $text = 'quête de performance, grâce à ses solutions d’amélioration de la qualité de vie et de fidélisation des salariés';

        $this->assertHtmlableEquals(
            '<meta name="keywords" content="' . $text . '">',
            $this->makeMetaTags()->setKeywords($text)
        );
    }

    function test_keywords_can_be_limited()
    {
        $this->assertHtmlableContains(
            '<meta name="keywords" content="test...">',
            $this->makeMetaTags()->setKeywords('test keywords', 4)
        );
    }

    function test_gets_max_keywords_length_from_config_by_default()
    {
        $config = $this->makeConfig();
        $config->shouldReceive('get')->once()->with('meta_tags.keywords.max_length', null)->andReturn(4);

        $this->assertHtmlableContains(
            '<meta name="keywords" content="test...">',
            $this->makeMetaTags(null, $config)->setKeywords('test keywords')
        );
    }

    function test_convert_to_array()
    {
        $this->assertEquals([
            'content' => 'test keywords',
            'type' => 'tag',
            'tag' => 'meta',
            'name' => 'keywords',
        ], $this->makeMetaTags()->setKeywords('test keywords')->getKeywords()->toArray());
    }
}
