<?php

namespace Butschster\Head\MetaTags\Entities;

class Description extends Tag
{
    use Concerns\ManageMaxLength;

    const DEFAULT_LENGTH = null;

    /**
     * @var string
     */
    protected $description;

    /**
     * @param string $description
     * @param int|null $maxLength
     */
    public function __construct(string $description, ?int $maxLength = self::DEFAULT_LENGTH)
    {
        parent::__construct('meta', []);

        $this->description = $description;
        $this->setMaxLength($maxLength);
    }

    /**
     * @return array
     */
    protected function getAttributes(): array
    {
        return array_merge([
            'name' => 'description',
            'content' => $this->limitString($this->description),
        ], parent::getAttributes());
    }
}
