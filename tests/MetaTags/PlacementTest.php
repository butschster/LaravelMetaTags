<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Placement;
use Butschster\Head\MetaTags\Entities\Tag;
use Butschster\Head\MetaTags\TagsCollection;
use Butschster\Tests\TestCase;
use Illuminate\Support\Collection;

class PlacementTest extends TestCase
{
    function test_it_extends_of_tags_collection()
    {
        $placement = new Placement();

        $this->assertInstanceOf(TagsCollection::class, $placement);
    }

    function test_in_can_be_converted_to_html()
    {
        $placement = new Placement();

        $placement->add(Tag::meta([
            'attr' => 'value'
        ]));

        $placement->add(Tag::meta([
            'attr' => 'value1'
        ]));

        $this->assertHtmlableContains([
            '<meta attr="value">',
            '<meta attr="value1">'
        ], $placement);
    }

    function test_invisible_tags_should_be_skipped()
    {
        $placement = new Placement();

        $placement->add(Tag::meta([
            'attr' => 'value'
        ]));

        $placement->add(Tag::meta([
            'attr' => 'value1'
        ])->visibleWhen(function () {
            return false;
        }));

        $this->assertHtmlableContains([
            '<meta attr="value">',
        ], $placement);

        $this->assertHtmlableNotContains([
            '<meta attr="value1">',
        ], $placement);
    }

    function test_converts_to_array()
    {
        $placement = new Placement();

        $placement->add(Tag::meta([
            'attr' => 'value'
        ]));

        $placement->add(Tag::meta([
            'attr' => 'value1'
        ])->visibleWhen(function () {
            return false;
        }));

        $this->assertEquals([
            [
                'attr' => 'value',
                'type' => 'tag',
                'tag' => 'meta',
            ],
            [
                'attr' => 'value1',
                'type' => 'tag',
                'tag' => 'meta',
            ]
        ], $placement->toArray());
    }

}
