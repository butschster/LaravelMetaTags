<?php

namespace Butschster\Head\MetaTags\Entities;

use Butschster\Head\Contracts\MetaTags\Entities\HasVisibilityConditions;
use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\MetaTags\Entities\Concerns\ManageVisibility;

class Comment implements TagInterface, HasVisibilityConditions, \Stringable
{
    use ManageVisibility;

    protected string $closeComment;

    public function __construct(
        protected TagInterface $tag,
        protected string $openComment,
        ?string $closeComment = null,
    ) {
        $this->closeComment = $closeComment ?: $openComment;
    }

    public function getTag(): TagInterface
    {
        return $this->tag;
    }

    public function toHtml(): string
    {
        return sprintf(
            <<<COM
<!-- %s -->
%s
<!-- /%s -->
COM
            ,
            $this->openComment,
            $this->tag->toHtml(),
            $this->closeComment,
        );
    }

    public function __toString(): string
    {
        return $this->toHtml();
    }

    public function getPlacement(): string
    {
        return $this->tag->getPlacement();
    }

    public function toArray(): array
    {
        return [
            'type' => 'comment',
            'tag' => $this->tag->toArray(),
            'content' => $this->toHtml(),
        ];
    }
}
