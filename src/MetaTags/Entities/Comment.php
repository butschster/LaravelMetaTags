<?php

namespace Butschster\Head\MetaTags\Entities;

use Butschster\Head\Contracts\MetaTags\Entities\HasVisibilityConditions;
use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\MetaTags\Entities\Concerns\ManageVisibility;

class Comment implements TagInterface, HasVisibilityConditions
{
    use ManageVisibility;

    /**
     * @var string
     */
    protected $openComment;

    /**
     * @var string
     */
    protected $closeComment;

    /**
     * @var TagInterface
     */
    protected $tag;

    /**
     * @param TagInterface $tag
     * @param string $openComment
     * @param string|null $closeComment
     */
    public function __construct(TagInterface $tag, string $openComment, ?string $closeComment = null)
    {
        $this->tag = $tag;
        $this->openComment = $openComment;
        $this->closeComment = $closeComment ?: $openComment;
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return sprintf(<<<COM
<!-- %s -->
%s
<!-- /%s -->
COM
, $this->openComment, $this->tag->toHtml(), $this->closeComment);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }

    /**
     * @return string
     */
    public function getPlacement(): string
    {
        return $this->tag->getPlacement();
    }

    public function toArray()
    {
        return [
            'type' => 'comment',
            'tag' => $this->tag->toArray(),
            'content' => $this->toHtml()
        ];
    }
}
