<?php

namespace Butschster\Head\MetaTags\Entities;

class Keywords extends Tag
{
    use Concerns\ManageMaxLength;

    const DEFAULT_LENGTH = null;

    /**
     * @var string
     */
    protected $keywords = [];

    /**
     * @param string|array $keywords
     * @param int|null $maxLength
     */
    public function __construct($keywords, ?int $maxLength = self::DEFAULT_LENGTH)
    {
        parent::__construct('meta', []);

        $this->keywords = is_array($keywords) ? $keywords : [$keywords];
        $this->setMaxLength($maxLength);
    }

    /**
     * @return array
     */
    protected function getAttributes(): array
    {
        return array_merge([
            'name' => 'keywords',
            'content' => $this->makeString($this->keywords),
        ], parent::getAttributes());
    }

    /**
     * @param array $keywords
     * @return string
     */
    protected function makeString(array $keywords): string
    {
        return $this->limitString(implode(', ', $keywords));
    }
}
