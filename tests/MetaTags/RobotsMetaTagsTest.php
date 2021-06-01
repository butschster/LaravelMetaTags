<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Tests\TestCase;

class RobotsMetaTagsTest extends TestCase
{
    function test_robots_from_string_can_be_set()
    {
        $meta = $this->makeMetaTags()
            ->setRobots('noindex');

        $this->assertHtmlableEquals(
            '<meta name="robots" content="noindex">',
            $meta->getRobots()
        );
    }

    function test_robots_from_string_can_be_null()
    {
        $this->assertHtmlableEquals(
            '<meta name="robots" content="">',
            $this->makeMetaTags()->setRobots(null)->getRobots()
        );
    }

    function test_set_robots_method_should_be_fluent()
    {
        $meta = $this->makeMetaTags();

        $this->assertEquals($meta, $meta->setRobots('noindex'));
    }

    function test_robots_should_be_null_if_not_set()
    {
        $meta = $this->makeMetaTags();

        $this->assertNull($meta->getRobots());
    }

    function test_robots_string_should_be_cleaned()
    {
        $meta = $this->makeMetaTags()
            ->setRobots('<h5>noindex</h5>');

        $this->assertHtmlableEquals(
            '<meta name="robots" content="noindex">',
            $meta->getRobots()
        );
    }

    function test_converts_to_array()
    {
        $this->assertEquals(
            [
                'name' => 'robots',
                'content' => 'noindex',
                'type' => 'tag',
                'tag' => 'meta',
            ],
            $this->makeMetaTags()->setRobots('noindex')->getRobots()->toArray()
        );
    }
}
