<?php

namespace Butschster\Head\MetaTags\Entities;

use Butschster\Head\Contracts\MetaTags\Entities\HasVisibilityConditions;
use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Closure;

class Tag implements TagInterface, HasVisibilityConditions
{
    use Concerns\ManagePlacements,
        Concerns\ManageVisibility;

    /**
     * Make a new instance
     *
     * @param string $tagName
     * @param array $attributes
     * @param bool $closeTag
     *
     * @return static
     */
    public static function make(string $tagName, array $attributes, bool $closeTag = false)
    {
        return new static($tagName, $attributes, $closeTag);
    }

    /**
     * Make a new meta tag
     *
     * @param array $attributes
     *
     * @return static
     */
    public static function meta(array $attributes)
    {
        return new static('meta', $attributes);
    }

    /**
     * Make a new link tag
     *
     * @param array $attributes
     *
     * @return static
     */
    public static function link(array $attributes)
    {
        return new static('link', $attributes);
    }

    /**
     * @var string
     */
    protected $tagName;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var bool
     */
    protected $closeTag;

    /**
     * @param string $tagName
     * @param array $attributes
     * @param bool $closeTag
     */
    public function __construct(string $tagName, array $attributes, bool $closeTag = false)
    {
        $this->tagName = $tagName;
        $this->attributes = $attributes;
        $this->closeTag = $closeTag;
    }

    /**
     * Build an HTML attribute string from an array.
     *
     * @return string
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

        return count($html) > 0
            ? implode(' ', $html)
            : '';
    }

    /**
     * @return array
     */
    protected function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Build a single attribute element.
     *
     * @param string $key
     * @param string $value
     *
     * @return string
     */
    protected function attributeElement($key, $value)
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
     *
     * @return string
     */
    public function toHtml()
    {
        return sprintf(
            '<%s %s%s>',
            $this->tagName,
            $this->compiledAttributes(),
            $this->closeTag ? ' /' : ''
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }

    public function toArray()
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
                $attributes[$key] = (string) $value;
            }
        }

        return $attributes + [
            'type' => 'tag',
            'tag' => $this->tagName
        ];
    }
}
