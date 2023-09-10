<?php

namespace Butschster\Head\MetaTags\Entities;

use Butschster\Head\Contracts\MetaTags\Entities\HasVisibilityConditions;
use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Closure;

class Tag implements TagInterface, HasVisibilityConditions, \Stringable
{
    use Concerns\ManagePlacements;
    use Concerns\ManageVisibility;
    public static function make(string $tagName, array $attributes, bool $closeTag = false): self
    {
        return new static($tagName, $attributes, $closeTag);
    }

    /**
     * Make a new meta tag
     */
    public static function meta(array $attributes): self
    {
        return new static('meta', $attributes);
    }

    /**
     * Make a new link tag
     */
    public static function link(array $attributes): self
    {
        return new static('link', $attributes);
    }

    public function __construct(
        protected string $tagName,
        protected array $attributes,
        protected bool $closeTag = false,
    ) {
    }

    /**
     * Build an HTML attribute string from an array.
     */
    public function compiledAttributes(): string
    {
        $html = [];

        foreach ($this->getAttributes() as $key => $value) {
            $element = $this->attributeElement($key, $value);

            if (!is_null($element)) {
                $html[] = $element;
            }
        }

        return $html !== []
            ? implode(' ', $html)
            : '';
    }

    protected function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Build a single attribute element.
     */
    protected function attributeElement(mixed $key, mixed $value): mixed
    {
        // For numeric keys we will assume that the key and the value are the same
        // as this will convert HTML attributes such as "required" to a correct
        // form like required="required" instead of using incorrect numerics.
        if (is_numeric($key)) {
            return $value;
        }

        if ($value instanceof Closure) {
            $value = $value();
        }

        if (!is_null($value)) {
            return $key . '="' . $value . '"';
        }
    }

    /**
     * Get content as a string of HTML.
     */
    public function toHtml(): string
    {
        return sprintf(
            '<%s %s%s>',
            $this->tagName,
            $this->compiledAttributes(),
            $this->closeTag ? ' /' : '',
        );
    }

    public function __toString(): string
    {
        return $this->toHtml();
    }

    public function toArray(): array
    {
        $attributes = [];

        foreach ($this->getAttributes() as $key => $value) {
            $element = $this->attributeElement($key, $value);

            if ($value instanceof Closure) {
                $value = $value();
            }

            if (is_numeric($key)) {
                $key = $value;
                $value = true;

                $attributes[$key] = $value;
            } else {
                $attributes[$key] = (string)$value;
            }
        }

        return $attributes + [
                'type' => 'tag',
                'tag' => $this->tagName,
            ];
    }
}
