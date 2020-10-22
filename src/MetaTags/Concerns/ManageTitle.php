<?php

namespace Butschster\Head\MetaTags\Concerns;

use Butschster\Head\Contracts\MetaTags\Entities\TitleInterface;
use Butschster\Head\MetaTags\Entities\Title;

trait ManageTitle
{
    /**
     * @inheritdoc
     */
    public function setTitle(?string $title, int $maxLength = null)
    {
        $this->getTitle()->setTitle($this->cleanString($title), $maxLength);

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
    public function prependTitle(?string $text)
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

            if ($defaultSeparator = $this->config('title.separator')) {
                $title->setSeparator($defaultSeparator);
            }

            $title->setMaxLength($this->config('title.max_length'));
        }

        return $title;
    }
}
