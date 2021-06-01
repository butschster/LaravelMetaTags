<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\Contracts\MetaTags\GeoMetaInformationInterface;
use Butschster\Tests\TestCase;
use Mockery as m;

class GeoMetaTagsTest extends TestCase
{
    function test_set_geo_meta_tags()
    {
        $metatags = m::mock(GeoMetaInformationInterface::class);

        $metatags->shouldReceive('latitude')->once()->andReturn('latitude');
        $metatags->shouldReceive('longitude')->once()->andReturn('longitude');
        $metatags->shouldReceive('placename')->once()->andReturn('Moscow');
        $metatags->shouldReceive('region')->once()->andReturn('Russia');

        $this->assertHtmlableContains([
            '<meta name="geo.position" content="latitude; longitude">',
            '<meta name="geo.placename" content="Moscow">',
            '<meta name="geo.region" content="Russia">'
        ], $this->makeMetaTags()->setGeo($metatags));
    }

    function test_set_geo_meta_tags_without_placename()
    {
        $metatags = m::mock(GeoMetaInformationInterface::class);

        $metatags->shouldReceive('latitude')->once()->andReturn('latitude');
        $metatags->shouldReceive('longitude')->once()->andReturn('longitude');
        $metatags->shouldReceive('placename')->once()->andReturn(null);
        $metatags->shouldReceive('region')->once()->andReturn('Russia');

        $meta = $this->makeMetaTags()->setGeo($metatags);

        $this->assertHtmlableNotContains(
            '<meta name="geo.placename" content="Moscow">',
            $meta
        );

        $this->assertHtmlableContains([
            '<meta name="geo.region" content="Russia">',
            '<meta name="geo.position" content="latitude; longitude">',
        ], $meta);
    }

    function test_set_geo_meta_tags_without_region()
    {
        $metatags = m::mock(GeoMetaInformationInterface::class);

        $metatags->shouldReceive('latitude')->once()->andReturn('latitude');
        $metatags->shouldReceive('longitude')->once()->andReturn('longitude');
        $metatags->shouldReceive('placename')->once()->andReturn('Moscow');
        $metatags->shouldReceive('region')->once()->andReturn(null);

        $meta = $this->makeMetaTags()->setGeo($metatags);

        $this->assertHtmlableContains([
            '<meta name="geo.placename" content="Moscow">',
            '<meta name="geo.position" content="latitude; longitude">'
        ], $meta);

        $this->assertHtmlableNotContains(
            '<meta name="geo.region" content="Russia">',
            $meta
        );
    }

    function test_convert_to_array()
    {

        $metatags = m::mock(GeoMetaInformationInterface::class);
        $metatags->shouldReceive('latitude')->once()->andReturn('latitude');
        $metatags->shouldReceive('longitude')->once()->andReturn('longitude');
        $metatags->shouldReceive('placename')->once()->andReturn('Moscow');
        $metatags->shouldReceive('region')->once()->andReturn('Russia');

        $this->assertEquals([
            [
                'name' => 'geo.position',
                'content' => 'latitude; longitude',
                'type' => 'tag',
                'tag' => 'meta',
            ],
            [
                'name' => 'geo.placename',
                'content' => 'Moscow',
                'type' => 'tag',
                'tag' => 'meta',
            ],
            [
                'name' => 'geo.region',
                'content' => 'Russia',
                'type' => 'tag',
                'tag' => 'meta',
            ],
        ], $this->makeMetaTags()->setGeo($metatags)->head()->toArray());
    }
}
