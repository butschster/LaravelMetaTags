<?php

namespace Butschster\Head\MetaTags\Entities;

use Butschster\Head\Contracts\MetaTags\Entities\HasVisibilityConditions;
use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use InvalidArgumentException;

class JavascriptVariables implements TagInterface, HasVisibilityConditions
{
    use Concerns\ManagePlacements,
        Concerns\ManageVisibility;

    /**
     * @var array
     */
    protected $variables = [];

    /**
     * The namespace to nest JS vars under.
     *
     * @var string
     */
    protected $namespace;

    /**
     * @param array $variables
     * @param string $namespace
     */
    public function __construct(array $variables = [], string $namespace = 'window')
    {
        $this->namespace = $namespace;
        $this->buildJavaScriptSyntax($variables);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     */
    public function put(string $key, $value)
    {
        // First, we have to translate the variables
        // to something JS-friendly.
        $this->buildJavaScriptSyntax([$key => $value]);

        return $this;
    }

    /**
     * Translate the array of PHP vars to
     * the expected JavaScript syntax.
     *
     * @param array $variables
     */
    protected function buildJavaScriptSyntax(array $variables)
    {
        foreach ($variables as $key => $value) {
            $this->variables[] = $this->buildVariableInitialization($key, $value);
        }
    }

    /**
     * Translate a single PHP var to JS.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return string
     * @throws InvalidArgumentException
     */
    protected function buildVariableInitialization(string $key, $value): string
    {
        return "{$this->namespace}.{$key} = {$this->optimizeValueForJavaScript($value)};";
    }

    /**
     * Create the namespace to which all vars are nested.
     *
     * @return string
     */
    protected function buildNamespaceDeclaration(): string
    {
        if ($this->namespace == 'window') {
            return '';
        }

        return "window.{$this->namespace} = window.{$this->namespace} || {};" . PHP_EOL;
    }

    /**
     * Format a value for JavaScript.
     *
     * @param string $value
     *
     * @return string
     * @throws \Exception
     *
     */
    protected function optimizeValueForJavaScript($value)
    {
        // For every transformable type, let's see if
        // it needs to be transformed for JS-use.
        $types = ['String', 'Array', 'Object', 'Numeric', 'Boolean', 'Null'];

        foreach ($types as $transformer) {
            $js = $this->{"transform{$transformer}"}($value);

            if (!is_null($js)) {
                return $js;
            }
        }
    }

    /**
     * Transform a string.
     *
     * @param string $value
     *
     * @return string
     */
    protected function transformString($value)
    {
        if (is_string($value)) {
            $value = str_replace(['\\', "'"], ['\\\\', "\'"], $value);
            return "'{$value}'";
        }
    }

    /**
     * Transform an array.
     *
     * @param array $value
     *
     * @return string
     */
    protected function transformArray($value)
    {
        if (is_array($value)) {
            return json_encode($value);
        }
    }

    /**
     * Transform a numeric value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    protected function transformNumeric($value)
    {
        if (is_numeric($value)) {
            return $value;
        }
    }

    /**
     * Transform a boolean.
     *
     * @param bool $value
     *
     * @return string
     */
    protected function transformBoolean($value)
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
    }

    /**
     * @param object $value
     *
     * @return string
     * @throws InvalidArgumentException
     *
     */
    protected function transformObject($value): ?string
    {
        if (!is_object($value)) {
            return null;
        }

        if ($value instanceof Jsonable) {
            return $value->toJson();
        }

        if ($value instanceof Arrayable) {
            return json_encode($value->toArray());
        }

        // Otherwise, if the object doesn't even have a
        // __toString() method, we can't proceed.
        if (!method_exists($value, '__toString')) {
            throw new InvalidArgumentException('Cannot transform this object to JavaScript.');
        }

        return "'{$value}'";
    }

    /**
     * Transform "null.".
     *
     * @param mixed $value
     *
     * @return string
     */
    protected function transformNull($value)
    {
        if (is_null($value)) {
            return 'null';
        }
    }


    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        $string = implode(PHP_EOL, $this->variables);
        $namespaceDeclaration = $this->buildNamespaceDeclaration();

        return sprintf(<<<VAR
<script>
%s
</script>
VAR
            , $namespaceDeclaration . $string);
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
        return [
            'type' => 'javascript_variables',
            'variables' => $this->variables
        ];
    }
}
