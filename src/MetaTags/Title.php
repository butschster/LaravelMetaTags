<?php

namespace Butschster\Head\MetaTags;

use Illuminate\Contracts\Support\Htmlable;

class Title implements Htmlable
{
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
     * @param string|null $title
     */
    public function __construct(string $title = null)
    {
        $this->title = $title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string $text
     */
    public function prepend(string $text): void
    {
        $this->prepend[] = $text;
    }

    /**
     * @param string $separator
     */
    public function setSeparator(string $separator)
    {
        $this->separator = trim($separator);
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

        return $title;
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return sprintf('<title>%s</title>', $this->makeTitle());
    }
}