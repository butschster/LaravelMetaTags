<?php

namespace Butschster\Tests\MetaTags\Entities;

use Butschster\Head\MetaTags\Entities\YandexMetrika;
use Butschster\Tests\TestCase;

class YandexMetrikaTest extends TestCase
{
    function test_it_can_be_created()
    {
        $tag = new YandexMetrika(20925319);

        $this->assertHtmlableContains([
            '<script type="text/javascript">',
            'ym(20925319, "init", {',
            '});',
            '</script>',
            '<noscript><div><img src="https://mc.yandex.ru/watch/20925319" style="position:absolute; left:-9999px;" alt="" /></div></noscript>',
        ], $tag);
    }

    function test_it_can_be_add_to_meta_class()
    {
        $meta = $this->makeMetaTags();
        $meta->addTag('yandex.metrika', new YandexMetrika(20925319));

        $this->assertHtmlableContains([
            '<script type="text/javascript">',
            'ym(20925319, "init", {',
            '});',
            '</script>',
            '<noscript><div><img src="https://mc.yandex.ru/watch/20925319" style="position:absolute; left:-9999px;" alt="" /></div></noscript>',
        ], $meta->footer());

        $this->assertHtmlableNotContains([
            'ym(20925319, "init", {',
        ], $meta);
    }

    function test_a_builder_can_be_used()
    {
        $tag = new YandexMetrika(20925319);

        $tag->webvisor(false)->useCDN();

        $this->assertHtmlableNotContains([
            '"webvisor":true',
            'https://mc.yandex.ru/metrika/tag.js',
        ], $tag);

        $this->assertHtmlableContains([
            'https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js'
        ], $tag);
    }

}
