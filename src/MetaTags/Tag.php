<?php

namespace Butschster\Head\MetaTags;

use Illuminate\Contracts\Support\Htmlable;

class Tag implements Htmlable
{
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
    public function compiledAttributes()
    {
        $html = [];

        foreach ($this->attributes as $key => $value) {
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
            $key = $value;
        }

        if (!is_null($value)) {
            return $key . '="' . e($value) . '"';
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
}