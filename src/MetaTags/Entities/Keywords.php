<?php

namespace Butschster\Head\MetaTags\Entities;

class Keywords extends Tag
{
    use Concerns\ManageMaxLength;

    public const DEFAULT_LENGTH = null;

    protected array $keywords = [];

    public function __construct(string|array $keywords, ?int $maxLength = self::DEFAULT_LENGTH)
    {
        parent::__construct('meta', []);

        $this->keywords = is_array($keywords) ? $keywords : [$keywords];
        $this->setMaxLength($maxLength);
    }

    public function getKeywords(): array
    {
        return $this->keywords;
    }

    protected function getAttributes(): array
    {
        return array_merge([
            'name' => 'keywords',
            'content' => $this->makeString($this->keywords),
        ], parent::getAttributes());
    }

    protected function makeString(array $keywords): string
    {
        return $this->limitString(implode(', ', $keywords));
    }
}
