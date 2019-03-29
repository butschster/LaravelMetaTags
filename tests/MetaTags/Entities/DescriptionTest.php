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

        $this->assertHtmlableEquals(
            '<meta name="description" content="Lorem Ipsum is simpl...">',
            $description->setMaxLength(20)
        );
    }

    function test_it_can_support_utf8()
    {
        $text = 'quête de performance, grâce à ses solutions d’amélioration de la qualité de vie et de fidélisation des salariés';

        $this->assertHtmlableEquals(
            '<meta name="description" content="'.$text.'">',
            new Description($text)
        );
    }
}