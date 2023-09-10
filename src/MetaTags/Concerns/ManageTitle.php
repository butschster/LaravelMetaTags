<?php

namespace Butschster\Head\MetaTags\Concerns;

use Butschster\Head\Contracts\MetaTags\Entities\TitleInterface;
use Butschster\Head\MetaTags\Entities\Title;

trait ManageTitle
{
    public function setTitle(?string $title, int $maxLength = null): self
    {
        $this->getTitle()->setTitle($this->cleanString($title), $maxLength);

        return $this;
    }

    public function setTitleSeparator(string $separator): self
    {
        $this->getTitle()->setSeparator($separator);

        return $this;
    }

    public function prependTitle(?string $text): self
    {
        $title = $this->getTitle();

        if ($title) {
            $title->prepend($this->cleanString($text));
        } else {
            $this->setTitle($text);
        }

        return $this;
    }

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
