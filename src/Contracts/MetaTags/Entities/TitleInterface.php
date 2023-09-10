<?php

namespace Butschster\Head\Contracts\MetaTags\Entities;

interface TitleInterface extends TagInterface
{
    /**
     * Specify max length of the title
     *
     * @param positive-int $maxLength
     */
    public function setMaxLength(int $maxLength): self;

    /**
     * Set the main title
     *
     * @param positive-int|null $maxLength
     */
    public function setTitle(?string $title, ?int $maxLength = null): self;

    /**
     * Prepend next part of title
     */
    public function prepend(string $text): self;

    /**
     * Toggle RTL mode
     */
    public function rtl(bool $status = true): self;

    /**
     * Determine separator among title parts
     */
    public function setSeparator(string $separator): self;

    /**
     * Get the title
     */
    public function getTitle(): string;
}
