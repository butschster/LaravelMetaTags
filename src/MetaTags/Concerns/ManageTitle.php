<?php

namespace Butschster\Head\MetaTags\Concerns;

use Butschster\Head\Contracts\MetaTags\Entities\TitleInterface;
use Butschster\Head\MetaTags\Entities\Title;

trait ManageTitle
{
    /**
     * @inheritdoc
     */
    public function setTitle(string $title)
    {
        $this->getTitle()->setTitle($this->cleanString($title));

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setTitleSeparator(string $separator)
    {
        $this->getTitle()->setSeparator($separator);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function prependTitle(string $text)
    {
        $title = $this->getTitle();

        if ($title) {
            $title->prepend($this->cleanString($text));
        } else {
            $this->setTitle($text);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTitle(): ?TitleInterface
    {
        $title = $this->getTag('title');

        if (!$title) {
            $this->addTag('title', $title = new Title());
        }

        return $title;
    }
}