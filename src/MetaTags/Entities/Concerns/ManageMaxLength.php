<?php

namespace Butschster\Head\MetaTags\Entities\Concerns;

use Illuminate\Support\Str;
use InvalidArgumentException;

trait ManageMaxLength
{
    protected ?int $maxLength = self::DEFAULT_LENGTH;

    public function setMaxLength(?int $maxLength): self
    {
        if (!is_null($maxLength) && $maxLength < 1) {
            throw new InvalidArgumentException('The maximum length must be greater 0.');
        }

        if ($maxLength > 0) {
            $this->maxLength = $maxLength;
        }

        return $this;
    }

    protected function limitString(string $string): string
    {
        if ($this->maxLength) {
            return Str::limit($string, $this->maxLength);
        }

        return $string;
    }
}
