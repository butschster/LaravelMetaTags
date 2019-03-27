<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\GeoMetaInformationInterface;
use Butschster\Tests\TestCase;
use Mockery as m;

class GeoMetaTagsTest extends TestCase
{
    function test_set_geo_meta_tags()
    {
        $meta = $this->makeMetaTags();

        $metatags = m::mock(GeoMetaInformationInterface::class);

        $metatags->shouldReceive('latitude')->once()->andReturn('latitude');
        $metatags->shouldReceive('longitude')->once()->andReturn('longitude');
        $metatags->shouldReceive('placename')->once()->andReturn('Moscow');
        $metatags->shouldReceive('region')->once()->andReturn('Russia');

        $meta->setGeo($metatags);

        $html = $meta->toHtml();

        $this->assertStringContainsString('<meta name="geo.position" content="latitude; longitude">', $html);
        $this->assertStringContainsString('<meta name="geo.placename" content="Moscow">', $html);
        $this->assertStringContainsString('<meta name="geo.region" content="Russia">', $html);
    }

    function test_set_geo_meta_tags_without_placename()
    {
        $meta = $this->makeMetaTags();

        $metatags = m::mock(GeoMetaInformationInterface::class);

        $metatags->shouldReceive('latitude')->once()->andReturn('latitude');
        $metatags->shouldReceive('longitude')->once()->andReturn('longitude');
        $metatags->shouldReceive('placename')->once()->andReturn(null);
        $metatags->shouldReceive('region')->once()->andReturn('Russia');

        $meta->setGeo($metatags);

        $html = $meta->toHtml();

        $this->assertStringContainsString('<meta name="geo.position" content="latitude; longitude">', $html);
        $this->assertStringNotContainsString('<meta name="geo.placename" content="Moscow">', $html);
        $this->assertStringContainsString('<meta name="geo.region" content="Russia">', $html);
    }

    function test_set_geo_meta_tags_without_region()
    {
        $meta = $this->makeMetaTags();

        $metatags = m::mock(GeoMetaInformationInterface::class);

        $metatags->shouldReceive('latitude')->once()->andReturn('latitude');
        $metatags->shouldReceive('longitude')->once()->andReturn('longitude');
        $metatags->shouldReceive('placename')->once()->andReturn('Moscow');
        $metatags->shouldReceive('region')->once()->andReturn(null);

        $meta->setGeo($metatags);

        $html = $meta->toHtml();

        $this->assertStringContainsString('<meta name="geo.position" content="latitude; longitude">', $html);
        $this->assertStringContainsString('<meta name="geo.placename" content="Moscow">', $html);
        $this->assertStringNotContainsString('<meta name="geo.region" content="Russia">', $html);
    }
}