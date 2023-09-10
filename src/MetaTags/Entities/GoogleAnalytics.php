<?php

namespace Butschster\Head\MetaTags\Entities;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\MetaTags\Meta;

class GoogleAnalytics implements TagInterface, \Stringable
{
    public function __construct(
        /** Google analytics identifier */
        private string $counterId,
    ) {
    }

    public function getCounterId(): string
    {
        return $this->counterId;
    }

    public function toHtml(): string
    {
        return sprintf(
            <<<TAG
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', '%s', 'auto');
    ga('send', 'pageview');
</script>
TAG
            ,
            $this->counterId,
        );
    }

    public function getPlacement(): string
    {
        return Meta::PLACEMENT_FOOTER;
    }

    public function __toString(): string
    {
        return $this->toHtml();
    }

    public function toArray(): array
    {
        return [
            'type' => 'google_analytics',
            'counter_id' => $this->counterId,
        ];
    }
}
