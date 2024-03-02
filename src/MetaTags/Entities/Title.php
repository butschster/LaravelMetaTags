<?php

namespace Butschster\Head\MetaTags\Entities;

use Butschster\Head\Contracts\MetaTags\Entities\HasVisibilityConditions;
use Butschster\Head\Contracts\MetaTags\Entities\TitleInterface;

class Title implements TitleInterface, HasVisibilityConditions, \Stringable
{
    use Concerns\ManageMaxLength;
    use Concerns\ManageVisibility;

    public const DEFAULT_LENGTH = null;

    protected string $separator = '|';

    protected array $prepend = [];

    protected bool $rtl = false;

    public function __construct(
        protected ?string $title = null,
        ?int $maxLength = self::DEFAULT_LENGTH
    ) {
        $this->setMaxLength($maxLength);
    }

    public function getPlacement(): string
    {
        return 'head';
    }

    public function setTitle(?string $title, ?int $maxLength = null): self
    {
        $this->title = $title;
        $this->setMaxLength($maxLength);

        return $this;
    }

    public function prepend(string $text): self
    {
        $this->prepend[] = $text;

        return $this;
    }

    /**
     * Toggle RTL mode
     */
    public function rtl(bool $status = true): self
    {
        $this->rtl = $status;

        return $this;
    }

    public function setSeparator(string $separator): self
    {
        $this->separator = trim($separator);

        return $this;
    }

    protected function makeTitle(): string
    {
        $separator = sprintf(' %s ', $this->separator);
        $title     = '';

        if (!empty($this->prepend)) {
            $parts = $this->rtl ? $this->prepend : array_reverse($this->prepend);
            $title = implode($separator, $parts);
        }

        if (!empty($title) && !empty($this->title)) {
            if ($this->rtl) {
                $title = $this->title . $separator . $title;
            } else {
                $title .= $separator . $this->title;
            }
        } elseif (!empty($this->title)) {
            $title = $this->title;
        }

        return $this->limitString($title);
    }

    public function toHtml(): string
    {
        return sprintf('<title>%s</title>', $this->makeTitle());
    }

    public function __toString(): string
    {
        return $this->toHtml();
    }

    public function toArray(): array
    {
        return [
            'tag'     => 'title',
            'content' => $this->makeTitle()
        ];
    }

    public function getTitle(): string
    {
        return $this->makeTitle();
    }

    /**
     * Get prepends title
     * @return array
     */
    public function getPrepends(): array
    {
        return $this->prepend;
    }

    /**
     * Get prepend title
     * @return string
     */
    public function getPrepend($index = 0): ?string
    {
        return $this->prepend[$index] ?? null;
    }
}
