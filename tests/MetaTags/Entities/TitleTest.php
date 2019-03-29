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

        $this->assertInstanceOf(Title::class, $title->prepend('another part'));

        $this->assertHtmlableEquals(
            '<title>another part | test title</title>',
            $title
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
}