<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Title;
use PHPUnit\Framework\TestCase;

class TitleTest extends TestCase
{
    function test_it_can_be_rendered_to_html()
    {
        $title = new Title();

        $title->setTitle('test title');

        $this->assertEquals('<title>test title</title>', $title->toHtml());
    }

    function test_title_can_be_prepend()
    {
        $title = new Title('test title');

        $title->prepend('another part');

        $this->assertEquals('<title>another part | test title</title>', $title->toHtml());
    }

    function test_separator_can_be_changed()
    {
        $title = new Title('test title');

        $title->prepend('another part');
        $title->setSeparator('->');

        $this->assertEquals('<title>another part -> test title</title>', $title->toHtml());
    }
}