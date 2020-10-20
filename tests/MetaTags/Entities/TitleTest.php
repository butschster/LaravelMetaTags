<?php

namespace Butschster\Tests\MetaTags\Entities;

use Butschster\Head\MetaTags\Entities\Title;
use Butschster\Tests\TestCase;

class TitleTest extends TestCase
{
    function test_it_can_be_rendered_to_html()
    {
        $title = new Title();

        $this->assertInstanceOf(Title::class, $title->setTitle('test title'));

        $this->assertHtmlableEquals(
            '<title>test title</title>',
            $title
        );
    }

    function test_title_can_be_prepend()
    {
        $title = new Title('test title');

        $this->assertHtmlableEquals(
            '<title>The end of the title | Another part of title | test title</title>',
            $title->prepend('Another part of title')
                ->prepend('The end of the title')
        );
    }

    function test_separator_can_be_changed()
    {
        $title = new Title('test title');

        $title->prepend('another part');
        $this->assertInstanceOf(Title::class, $title->setSeparator('->'));

        $this->assertHtmlableEquals(
            '<title>another part -> test title</title>',
            $title
        );
    }

    function test_a_title_should_be_limited_if_it_exceeded_max_length()
    {
        $title = new Title('test title');
        $title->prepend('another part')
            ->setMaxLength(20);

        $this->assertHtmlableEquals(
            '<title>another part | test...</title>',
            $title
        );
    }

    function test_it_can_support_utf8()
    {
        $title = new Title(
            $text = 'quête de performance, grâce à ses solutions d’amélioration de la qualité de vie et de fidélisation des salariés'
        );

        $this->assertHtmlableEquals(
            "<title>quête de performance, grâce à ses solutions d’amélioration de la qualité de vie et de fidélisation des salariés</title>",
            $title
        );
    }

    function test_max_length_should_be_greater_than_zero()
    {
        $title = new Title('test title');
        $title->prepend('another part');

        try {
            $title->setMaxLength(0);
            $this->fail();
        } catch (\InvalidArgumentException $e) {

        }

        try {
            $title->setMaxLength(-100);
            $this->fail();
        } catch (\InvalidArgumentException $e) {

        }

        $this->assertInstanceOf(Title::class, $title->setMaxLength(1));
    }

    function test_it_can_support_rtl_title()
    {
        $title = new Title('Site name');

        $title->prepend('Another part of title')
            ->prepend('The end of the title')
            ->setSeparator('-')
            ->rtl();

        $this->assertHtmlableEquals(
            '<title>Site name - Another part of title - The end of the title</title>',
            $title
        );
    }

    function test_if_max_length_is_null_then_text_should_not_cut()
    {
        $text = 'Lorem ipsum dolor sit amet, ei omnium accommodare definitionem sed, cum ut esse nihil fabellas.
        Ne eam autem nihil eloquentiam, eius ornatus no ius. Sint oportere scripserit vel cu, eu nec debitis
        mediocrem gubergren. Vim sonet sensibus ea, est justo adipisci constituam ex. Percipitur voluptatibus
        usu ad. Ea audiam ornatus eum, eros homero ridens et vim.';
        $title = new Title($text);

        $this->assertHtmlableContains($text, $title);
    }

    function test_by_default_title_is_visible()
    {
        $title = new Title('test');

        $this->assertTrue($title->isVisible());
    }

    function test_visibility_condition_can_be_set()
    {
        $title = new Title('test');

        // Make it invisible
        $this->assertFalse($title->visibleWhen(function () {return false;})->isVisible());

        // Make it visible
        $this->assertTrue($title->visibleWhen(function () {return true;})->isVisible());
    }
}
