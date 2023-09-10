<?php

namespace Butschster\Head\MetaTags\Entities;

class Description extends Tag
{
    use Concerns\ManageMaxLength;

    public const DEFAULT_LENGTH = null;

    public function __construct(
        protected string $description,
        ?int $maxLength = self::DEFAULT_LENGTH
    ) {
        parent::__construct('meta', []);

        $this->setMaxLength($maxLength);
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    protected function getAttributes(): array
    {
        return array_merge([
            'name' => 'description',
            'content' => $this->limitString($this->description),
        ], parent::getAttributes());
    }
}
