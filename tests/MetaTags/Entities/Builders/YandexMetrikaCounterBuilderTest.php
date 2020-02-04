<?php

namespace Butschster\Tests\MetaTags\Entities\Builders;

use Butschster\Head\MetaTags\Entities\Builders\YandexMetrikaCounterBuilder;
use Butschster\Tests\TestCase;

class YandexMetrikaCounterBuilderTest extends TestCase
{
    function test_a_code_counter_should_be_generated()
    {
        $builder = $this->getYandexMetrikaCounterBuilder();

        $this->assertEquals(
            $this->getScriptWithSettings(),
            $builder->toHtml()
        );
    }

    function test_clickmap_setting_can_be_switched()
    {
        $builder = $this->getYandexMetrikaCounterBuilder();

        $this->assertEquals($builder->clickmap(false), $builder);

        $this->assertEquals(
            $this->getScriptWithSettings('{"trackLinks":true,"accurateTrackBounce":true,"webvisor":true}'),
            $builder->toHtml()
        );

        $builder->clickmap(true);

        $this->assertEquals(
            $this->getScriptWithSettings(),
            $builder->toHtml()
        );
    }

    function test_webvisor_setting_can_be_switched()
    {
        $builder = $this->getYandexMetrikaCounterBuilder();

        $this->assertEquals($builder->webvisor(false), $builder);

        $this->assertEquals(
            $this->getScriptWithSettings('{"clickmap":true,"trackLinks":true,"accurateTrackBounce":true}'),
            $builder->toHtml()
        );

        $builder->webvisor(true);

        $this->assertEquals(
            $this->getScriptWithSettings(),
            $builder->toHtml()
        );
    }

    function test_track_links_setting_can_be_switched()
    {
        $builder = $this->getYandexMetrikaCounterBuilder();

        $this->assertEquals($builder->trackLinks(false), $builder);

        $this->assertEquals(
            $this->getScriptWithSettings('{"clickmap":true,"accurateTrackBounce":true,"webvisor":true}'),
            $builder->toHtml()
        );

        $builder->trackLinks(true);

        $this->assertEquals(
            $this->getScriptWithSettings(),
            $builder->toHtml()
        );
    }

    function test_track_hash_setting_can_be_switched()
    {
        $builder = $this->getYandexMetrikaCounterBuilder();

        $this->assertEquals($builder->trackHash(true), $builder);

        $this->assertEquals(
            $this->getScriptWithSettings('{"clickmap":true,"trackLinks":true,"accurateTrackBounce":true,"webvisor":true,"trackHash":true}'),
            $builder->toHtml()
        );

        $builder->trackHash(false);

        $this->assertEquals(
            $this->getScriptWithSettings(),
            $builder->toHtml()
        );
    }

    function test_accurate_track_bounce_can_be_switched()
    {
        $builder = $this->getYandexMetrikaCounterBuilder();

        $this->assertEquals($builder->accurateTrackBounce(false), $builder);

        $this->assertEquals(
            $this->getScriptWithSettings('{"clickmap":true,"trackLinks":true,"webvisor":true}'),
            $builder->toHtml()
        );

        $builder->accurateTrackBounce(true);

        $this->assertEquals(
            $this->getScriptWithSettings(),
            $builder->toHtml()
        );
    }

    function test_ecommerce_setting_can_be_enabled()
    {
        $builder = $this->getYandexMetrikaCounterBuilder();

        $this->assertEquals($builder->eCommerce('dataLayer'), $builder);

        $this->assertEquals(
            $this->getScriptWithSettings('{"clickmap":true,"trackLinks":true,"accurateTrackBounce":true,"webvisor":true,"ecommerce":"dataLayer"}'),
            $builder->toHtml()
        );
    }

    function test_an_alternate_cdn_can_be_used()
    {
        $builder = $this->getYandexMetrikaCounterBuilder();
        $this->assertEquals($builder->useCDN(), $builder);

        $this->assertEquals(
            $this->getScriptWithSettings('{"clickmap":true,"trackLinks":true,"accurateTrackBounce":true,"webvisor":true}', true),
            $builder->toHtml()
        );
    }

    function test_noscript_tag_can_be_disabled()
    {
        $builder = $this->getYandexMetrikaCounterBuilder();
        $this->assertEquals($builder->disableNoScript(), $builder);

        $this->assertEquals(
            $this->getScriptWithSettings('{"clickmap":true,"trackLinks":true,"accurateTrackBounce":true,"webvisor":true}', false, false),
            $builder->toHtml()
        );
    }

    /**
     * @return YandexMetrikaCounterBuilder
     */
    private function getYandexMetrikaCounterBuilder(): YandexMetrikaCounterBuilder
    {
        return new YandexMetrikaCounterBuilder(20413501);
    }

    /**
     * @param string $settings
     * @param bool $useCDN
     * @param bool $showNoScript
     *
     * @return string
     */
    private function getScriptWithSettings(
        string $settings = '{"clickmap":true,"trackLinks":true,"accurateTrackBounce":true,"webvisor":true}',
        bool $useCDN = false,
        bool $showNoScript = true
    ): string
    {
        return sprintf(<<<TAG
<script type="text/javascript">
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "%s", "ym");

   ym(20413501, "init", %s);
</script>
%s
TAG
            ,
            $useCDN ? 'https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js' : 'https://mc.yandex.ru/metrika/tag.js',
            $settings,
            $showNoScript ? '<noscript><div><img src="https://mc.yandex.ru/watch/20413501" style="position:absolute; left:-9999px;" alt="" /></div></noscript>' : '');
    }
}
