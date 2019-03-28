<?php

namespace Butschster\Head\MetaTags\Entities;

use Butschster\Head\Contracts\MetaTags\Entities\TitleInterface;
use Illuminate\Support\Str;

class Title implements TitleInterface
{
    const DEFAULT_LENGTH = 255;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $separator = '|';

    /**
     * @var array
     */
    protected $prepend = [];

    /**
     * @var int
     */
    protected $maxLength = Title::DEFAULT_LENGTH;

    /**
     * @param string|null $title
     * @param int $maxLength
     */
    public function __construct(string $title = null, int $maxLength = Title::DEFAULT_LENGTH)
    {
        $this->title = $title;
        $this->maxLength = $maxLength;
    }

    /**
     * @inheritdoc
     */
    public function getPlacement(): string
    {
        return 'head';
    }

    /**
     * @inheritdoc
     */
    public function setMaxLength(int $maxLength)
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setTitle(?string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function prepend(string $text)
    {
        $this->prepend[] = $text;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setSeparator(string $separator)
    {
        $this->separator = trim($separator);

        return $this;
    }

    /**
     * @return string
     */
    protected function makeTitle(): string
    {
        $separator = " {$this->separator} ";
        $title = '';

        if (!empty($this->prepend)) {
            $title = implode($separator, $this->prepend);
        }

        if (!empty($title) && !empty($this->title)) {
            $title .= $separator . $this->title;
        } else if (!empty($this->title)) {
            $title = $this->title;
        }

        return Str::limit($title, $this->maxLength);
    }

    /**
     * @inheritdoc
     */
    public function toHtml()
    {
        return sprintf('<title>%s</title>', $this->makeTitle());
    }

    /**
     * @inheritdoc
     */
    public function getAttributes(): array
    {
        return [];
    }
}