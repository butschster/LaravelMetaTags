<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Tests\TestCase;

class RobotsMetaTagsTest extends TestCase
{
    function test_robots_from_string_can_be_set()
    {
        $meta = $this->makeMetaTags();

        $meta->setRobots('noindex');

        $this->assertEquals(
            '<meta name="robots" content="noindex">',
            $meta->getRobots()->toHtml()
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
        $meta = $this->makeMetaTags();

        $meta->setRobots('<h5>noindex</h5>');

        $this->assertEquals(
            '<meta name="robots" content="noindex">',
            $meta->getRobots()->toHtml()
        );
    }
}