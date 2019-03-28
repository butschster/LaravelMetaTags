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

        $this->assertEquals('<title>test title</title>', $title->toHtml());
    }

    function test_title_can_be_prepend()
    {
        $title = new Title('test title');

        $this->assertInstanceOf(Title::class, $title->prepend('another part'));

        $this->assertEquals('<title>another part | test title</title>', $title->toHtml());
    }

    function test_separator_can_be_changed()
    {
        $title = new Title('test title');

        $title->prepend('another part');
        $this->assertInstanceOf(Title::class, $title->setSeparator('->'));

        $this->assertEquals('<title>another part -> test title</title>', $title->toHtml());
    }

    function test_a_title_should_be_limited_if_it_exceeded_max_length()
    {
        $title = new Title('test title');
        $title->prepend('another part');
        $title->setMaxLength(20);

        $this->assertEquals('<title>another part | test </title>', $title->toHtml());
    }
}