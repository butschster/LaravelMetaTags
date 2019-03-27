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
        });

        $meta = $this->makeMetaTags();

        $meta->setMetaTagsFromPage($page);

        $this->assertStringContainsString('<title>Laravel</title>', $meta->toHtml());
        $this->assertStringContainsString('<meta name="description" content="The best php framework">', $meta->toHtml());
        $this->assertStringContainsString('<meta name="keywords" content="php, framework">', $meta->toHtml());
    }
}

interface Page {
    public function getTitle(): string;
    public function getDescription(): string;
    public function getKeywords(): array;
}