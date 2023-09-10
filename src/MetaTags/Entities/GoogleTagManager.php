<?php

namespace Butschster\Head\MetaTags\Entities;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\MetaTags\Meta;

class GoogleTagManager implements TagInterface, \Stringable
{
    public function __construct(
        /** Google analytics identifier */
        private string $counterId
    ) {
    }

    public function getCounterId(): string
    {
        return $this->counterId;
    }

    public function toHtml(): string
    {
        return sprintf(<<<TAG
<script async src="https://www.googletagmanager.com/gtag/js?id=%s"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '%s');
</script>
TAG
            , $this->counterId, $this->counterId
        );
    }

    public function getPlacement(): string
    {
        return Meta::PLACEMENT_HEAD;
    }

    public function __toString(): string
    {
        return $this->toHtml();
    }

    public function toArray(): array
    {
        return [
            'type' => 'google_tag_manager',
            'counter_id' => $this->counterId
        ];
    }
}
