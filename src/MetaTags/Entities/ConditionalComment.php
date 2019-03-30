<?php

namespace Butschster\Head\MetaTags\Entities;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;

class ConditionalComment extends Comment
{
    /**
     * @param TagInterface $tag
     * @param string $condition
     */
    public function __construct(TagInterface $tag, string $condition)
    {
        parent::__construct($tag, $condition);
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return sprintf(<<<COM
<!--[if %s]>
%s
<![endif]-->
COM
            , $this->openComment, $this->tag->toHtml());
    }
}