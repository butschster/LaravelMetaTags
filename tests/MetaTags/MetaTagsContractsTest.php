<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\Contracts\MetaTags\GeoMetaInformationInterface;
use Butschster\Head\Contracts\MetaTags\RobotsTagsInterface;
use Butschster\Head\Contracts\MetaTags\SeoMetaTagsInterface;
use Butschster\Tests\TestCase;

class MetaTagsContractsTest extends TestCase
{
    function test_seo_meta_tags_can_be_set_from_object_with_contract_SeoMetaTagsInterface()
    {
        $page = new FakePage();

        $meta = $this->makeMetaTags()
            ->setMetaFrom($page);

        $this->assertHtmlableContains([
            '<title>Page title</title>',
            '<meta name="description" content="Page description">',
            '<meta name="keywords" content="php, framework">',
            '<meta name="robots" content="noindex, nofollow">',
            '<meta name="geo.region" content="Russia">',
            '<meta name="geo.placename" content="Moscow">',
            '<meta name="geo.position" content="37.620407; 55.754093">'
        ], $meta);
    }
}

class FakePage implements SeoMetaTagsInterface, RobotsTagsInterface, GeoMetaInformationInterface
{
    /**
     * @inheritDoc
     */
    public function getTitle(): ?string
    {
        return 'Page title';
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): ?string
    {
        return 'Page description';
    }

    /**
     * @inheritDoc
     */
    public function getKeywords()
    {
        return ['php', 'framework'];
    }

    /**
     * @inheritDoc
     */
    public function getRobots(): ?string
    {
        return 'noindex, nofollow';
    }

    /**
     * @inheritDoc
     */
    public function latitude(): string
    {
        return '37.620407';
    }

    /**
     * @inheritDoc
     */
    public function longitude(): string
    {
        return '55.754093';
    }

    /**
     * @inheritDoc
     */
    public function placename(): ?string
    {
        return 'Moscow';
    }

    /**
     * @inheritDoc
     */
    public function region(): ?string
    {
        return 'Russia';
    }
}