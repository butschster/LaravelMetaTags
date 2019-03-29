<?php

namespace Butschster\Head\MetaTags\Entities;

use Illuminate\Support\Str;
use InvalidArgumentException;

class Keywords extends Tag
{
    const DEFAULT_LENGTH = 255;

    /**
     * @var string
     */
    protected $keywords = [];

    /**
     * @var int
     */
    protected $maxLength = Keywords::DEFAULT_LENGTH;

    /**
     * @param string|array $keywords
     * @param int $maxLength
     */
    public function __construct($keywords, int $maxLength = Keywords::DEFAULT_LENGTH)
    {
        parent::__construct('meta', []);

        $this->keywords = is_array($keywords) ? $keywords : [$keywords];
        $this->maxLength = $maxLength;
    }

    /**
     * @return array
     */
    protected function getAttributes(): array
    {
        return array_merge([
            'name' => 'keywords',
            'content' => $this->limitString($this->keywords),
        ], parent::getAttributes());
    }

    /**
     * @inheritdoc
     */
    public function setMaxLength(int $maxLength)
    {
        if ($maxLength < 1) {
            throw new InvalidArgumentException('The keywords maximum length must be greater 0.');
        }

        $this->maxLength = $maxLength;

        return $this;
    }

    /**
     * @param array $keywords
     * @return string
     */
    protected function makeString(array $keywords): string
    {
        return implode(', ', $keywords);
    }

    /**
     * @param array $keywords
     * @return string
     */
    protected function limitString(array $keywords): string
    {
        return Str::limit(
            $this->makeString($keywords),
            $this->maxLength
        );
    }
}