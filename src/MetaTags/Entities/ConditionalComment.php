<?php

namespace Butschster\Head\MetaTags\Entities;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;

class ConditionalComment extends Comment
{
    public function __construct(TagInterface $tag, string $condition)
    {
        parent::__construct($tag, $condition);
    }

    public function toHtml(): string
    {
        return sprintf(<<<COM
<!--[if %s]>
%s
<![endif]-->
COM
            , $this->openComment, $this->tag->toHtml());
    }
}
