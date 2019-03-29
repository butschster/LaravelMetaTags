<?php

namespace Butschster\Tests\MetaTags\Entities;

use Butschster\Head\MetaTags\Entities\Description;
use Butschster\Tests\TestCase;

class DescriptionTest extends TestCase
{
    function test_it_can_be_rendered_to_html()
    {
        $this->assertHtmlableEquals(
            '<meta name="description" content="test">',
            new Description('test')
        );
    }

    function test_a_description_should_be_limited_if_it_exceeded_max_length()
    {
        $description = new Description('Lorem Ipsum is simply dummy text of the printing and typesetting');

        $this->assertInstanceOf(
            Description::class,
            $description->setMaxLength(20)
        );

        $this->assertHtmlableEquals(
            '<meta name="description" content="Lorem Ipsum is simpl...">',
            $description
        );
    }
}