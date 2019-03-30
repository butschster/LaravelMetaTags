<?php

namespace Butschster\Tests\MetaTags\Entities;

use Butschster\Head\MetaTags\Entities\Keywords;
use Butschster\Tests\TestCase;

class KeywordsTest extends TestCase
{
    function test_it_can_be_rendered_to_html()
    {
        $this->assertHtmlableEquals(
            '<meta name="keywords" content="tag, another-tag">',
            new Keywords('tag, another-tag')
        );
    }

    function test_keywords_can_be_set_from_array_be_rendered_to_html()
    {
        $this->assertHtmlableEquals(
            '<meta name="keywords" content="tag, another-tag">',
            new Keywords(['tag', 'another-tag'])
        );
    }

    function test_a_description_should_be_limited_if_it_exceeded_max_length()
    {
        $keywords = new Keywords(['Lorem Ipsum is si', 'mply dummy text of the printing and typesetting']);

        $this->assertHtmlableEquals(
            '<meta name="keywords" content="Lorem Ipsum is si, m...">',
            $keywords->setMaxLength(20)
        );
    }

    function test_it_can_support_utf8()
    {
        $text = 'quête de performance, grâce à ses solutions d’amélioration de la qualité de vie et de fidélisation des salariés';

        $this->assertHtmlableEquals(
            '<meta name="keywords" content="'.$text.'">',
            new Keywords($text)
        );
    }

    function test_if_max_length_is_null_then_text_should_not_cut()
    {
        $text = 'Lorem ipsum dolor sit amet, ei omnium accommodare definitionem sed, cum ut esse nihil fabellas. 
        Ne eam autem nihil eloquentiam, eius ornatus no ius. Sint oportere scripserit vel cu, eu nec debitis 
        mediocrem gubergren. Vim sonet sensibus ea, est justo adipisci constituam ex. Percipitur voluptatibus 
        usu ad. Ea audiam ornatus eum, eros homero ridens et vim.';
        $keywords = new Keywords($text);

        $this->assertHtmlableContains($text, $keywords);
    }
}