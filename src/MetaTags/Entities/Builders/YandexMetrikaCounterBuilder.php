<?php

namespace Butschster\Head\MetaTags\Entities\Builders;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

class YandexMetrikaCounterBuilder implements Htmlable, Arrayable, \Stringable
{
    /**
     * Counter settings
     */
    private array $settings = [
        'clickmap' => true,
        'trackLinks' => true,
        'accurateTrackBounce' => true,
        'webvisor' => true,
    ];

    private string $scriptUrl = 'https://mc.yandex.ru/metrika/tag.js';

    private bool $forXML = true;

    public function __construct(
        private string $counterId
    ) {
    }

    /**
     * @see https://yandex.ru/support/metrica/behavior/click-map.html#click-map
     */
    public function clickmap(bool $state = true): self
    {
        $this->settings['clickmap'] = $state;

        return $this;
    }

    /**
     * Вебвизор, карта скроллинга, аналитика форм
     *
     * Подробные записи действий посетителей на сайте: движения мышью, прокручивание страницы и клики.
     *
     * @see https://yandex.ru/support/metrica/webvisor/settings.html
     */
    public function webvisor(bool $state = true): self
    {
        $this->settings['webvisor'] = $state;

        return $this;
    }

    /**
     * Собирается ли статистика на внешние ресурсы, данные о загрузке файлов и данные о нажатии на кнопку "Поделиться".
     *
     * @see https://yandex.ru/support/metrica/behavior/link-map.html
     */
    public function trackLinks(bool $state = true): self
    {
        $this->settings['trackLinks'] = $state;

        return $this;
    }

    /**
     * Точный показатель отказов
     */
    public function accurateTrackBounce(bool $state = true): self
    {
        $this->settings['accurateTrackBounce'] = $state;

        return $this;
    }

    /**
     * Опция применима для AJAX-сайтов.
     */
    public function trackHash(bool $state = true): self
    {
        $this->settings['trackHash'] = $state;

        return $this;
    }

    /**
     * Опция позволяет отслеживать взаимодействие посетителей с товарами сайта.
     * Чтобы статистика начала собираться, настройте на сайте передачу данных.
     *
     * @see https://yandex.ru/support/metrica/data/e-commerce.html
     */
    public function eCommerce(string $containerName): self
    {
        $this->settings['ecommerce'] = $containerName;

        return $this;
    }

    /**
     * Позволяет корректно учитывать посещения из регионов, в которых ограничен доступ к ресурсам Яндекса.
     * Использование этой опции может снизить скорость загрузки кода счётчика.
     */
    public function useCDN(): self
    {
        $this->scriptUrl = 'https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js';

        return $this;
    }

    /**
     * Элемент noscript не должен использоваться в XML-документах (Content‑Type:application/xhtml+xml).
     */
    public function disableNoScript(): self
    {
        $this->forXML = false;

        return $this;
    }

    /**
     * Generate HTML script for Yandex counter
     */
    public function toHtml(): string
    {
        return sprintf(<<<TAG
<script type="text/javascript">
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "%s", "ym");

   ym(%s, "init", %s);
</script>
%s
TAG
            , $this->scriptUrl,
            $this->counterId,
            json_encode($this->filteredSettings(), JSON_THROW_ON_ERROR),
            $this->getNoscriptHtml()
        );
    }

    private function getNoscriptHtml(): string
    {
        if (!$this->forXML) {
            return '';
        }

        return sprintf(
            '<noscript><div><img src="https://mc.yandex.ru/watch/%s" style="position:absolute; left:-9999px;" alt="" /></div></noscript>',
            $this->counterId
        );
    }

    public function __toString(): string
    {
        return $this->toHtml();
    }

    /**
     * Get settings without false values
     */
    private function filteredSettings(): array
    {
        return array_filter($this->settings);
    }

    public function toArray(): array
    {
        return [
            'settings' => $this->settings,
            'counter_id' => $this->counterId,
        ];
    }
}
