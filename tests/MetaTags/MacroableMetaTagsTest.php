<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Meta;
use Butschster\Tests\TestCase;
use Mockery;

class MacroableMetaTagsTest extends TestCase
{
    function test_it_can_be_extend()
    {
        $page = Mockery::mock(Page::class);

        $page->shouldReceive('getTitle')->once()->andReturn('Laravel');
        $page->shouldReceive('getDescription')->once()->andReturn('The best php framework');
        $page->shouldReceive('getKeywords')->once()->andReturn(['php', 'framework']);

        Meta::macro('setMetaTagsFromPage', function(Page $page) {
            $this->setTitle($page->getTitle());
            $this->setDescription($page->getDescription());
            $this->setKeywords($page->getKeywords());

            return $this;
        });

        $meta = $this->makeMetaTags()
            ->setMetaTagsFromPage($page);

        $this->assertHtmlableContains([
            '<title>Laravel</title>',
            '<meta name="description" content="The best php framework">',
            '<meta name="keywords" content="php, framework">'
        ], $meta);
    }
}

interface Page {
    public function getTitle(): string;
    public function getDescription(): string;
    public function getKeywords(): array;
}