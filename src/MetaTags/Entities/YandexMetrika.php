<?php

namespace Butschster\Head\MetaTags\Entities;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;

class YandexMetrika implements TagInterface
{
    /**
     * @var string
     */
    protected $counterId;

    /**
     * @param string $counterId
     */
    public function __construct(string $counterId)
    {
        $this->counterId = $counterId;
    }

    /**
     * @return string
     */
    public function getPlacement(): string
    {
        return 'footer';
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return <<<TAG
<script type="text/javascript">
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym({$this->counterId}, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/40925319" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
TAG;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }
}