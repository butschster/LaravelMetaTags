<?php

namespace Butschster\Head\MetaTags\Entities;

use Illuminate\Support\Str;
use InvalidArgumentException;

class Description extends Tag
{
    const DEFAULT_LENGTH = 255;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var int
     */
    protected $maxLength = Description::DEFAULT_LENGTH;

    /**
     * @param string $description
     * @param int $maxLength
     */
    public function __construct(string $description, int $maxLength = Description::DEFAULT_LENGTH)
    {
        parent::__construct('meta', []);

        $this->description = $description;
        $this->maxLength = $maxLength;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return array_merge([
            'name' => 'description',
            'content' => Str::limit($this->description, $this->maxLength),
        ], parent::getAttributes());
    }

    /**
     * @inheritdoc
     */
    public function setMaxLength(int $maxLength)
    {
        if ($maxLength < 1) {
            throw new InvalidArgumentException('The description maximum length must be greater 0.');
        }

        $this->maxLength = $maxLength;

        return $this;
    }
}