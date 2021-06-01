<?php

namespace Butschster\Head\MetaTags\Entities;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\MetaTags\Meta;

class GoogleAnalytics implements TagInterface
{
    /**
     * Google analytics identifier
     *
     * @var string
     */
    private $counterId;

    /**
     * @param string $counterId Google analytics identifier
     */
    public function __construct(string $counterId)
    {
        $this->counterId = $counterId;
    }

    /**
     * @inheritDoc
     */
    public function toHtml()
    {
        return sprintf(<<<TAG
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', '%s', 'auto');
    ga('send', 'pageview');
</script>
TAG
        , $this->counterId
);
    }

    /**
     * @inheritDoc
     */
    public function getPlacement(): string
    {
        return Meta::PLACEMENT_FOOTER;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }

    public function toArray()
    {
        return [
            'type' => 'google_analytics',
            'counter_id' => $this->counterId
        ];
    }
}
