<?php

namespace Butschster\Head\MetaTags\Entities;

use Butschster\Head\Contracts\MetaTags\Entities\HasVisibilityConditions;
use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use InvalidArgumentException;

class JavascriptVariables implements TagInterface, HasVisibilityConditions, \Stringable
{
    use Concerns\ManagePlacements;
    use Concerns\ManageVisibility;
    protected array $variables = [];

    public function __construct(array $variables = [], /**
     * The namespace to nest JS vars under.
     */
    protected string $namespace = 'window')
    {
        $this->buildJavaScriptSyntax($variables);
    }

    public function put(string $key, mixed $value): self
    {
        // First, we have to translate the variables
        // to something JS-friendly.
        $this->buildJavaScriptSyntax([$key => $value]);

        return $this;
    }

    /**
     * Translate the array of PHP vars to
     * the expected JavaScript syntax.
     */
    protected function buildJavaScriptSyntax(array $variables): void
    {
        foreach ($variables as $key => $value) {
            $this->variables[] = $this->buildVariableInitialization($key, $value);
        }
    }

    /**
     * Translate a single PHP var to JS.
     *
     * @throws InvalidArgumentException
     */
    protected function buildVariableInitialization(string $key, mixed $value): string
    {
        return sprintf('%s.%s = %s;', $this->namespace, $key, $this->optimizeValueForJavaScript($value));
    }

    /**
     * Create the namespace to which all vars are nested.
     */
    protected function buildNamespaceDeclaration(): string
    {
        if ($this->namespace == 'window') {
            return '';
        }

        return sprintf('window.%s = window.%s || {};', $this->namespace, $this->namespace) . PHP_EOL;
    }

    /**
     * Format a value for JavaScript.
     *
     * @throws \Exception
     *
     */
    protected function optimizeValueForJavaScript(mixed $value): mixed
    {
        // For every transformable type, let's see if
        // it needs to be transformed for JS-use.
        $types = ['String', 'Array', 'Object', 'Numeric', 'Boolean', 'Null'];

        foreach ($types as $transformer) {
            $js = $this->{'transform' . $transformer}($value);

            if (!is_null($js)) {
                return $js;
            }
        }
    }

    /**
     * Transform a string.
     */
    protected function transformString(mixed $value): ?string
    {
        if (is_string($value)) {
            $value = str_replace(['\\', "'"], ['\\\\', "\'"], $value);
            return sprintf('\'%s\'', $value);
        }

        return null;
    }

    /**
     * Transform an array.
     */
    protected function transformArray(mixed $value): ?string
    {
        if (is_array($value)) {
            return json_encode($value, JSON_THROW_ON_ERROR);
        }

        return null;
    }

    /**
     * Transform a numeric value.
     */
    protected function transformNumeric(mixed $value)
    {
        if (is_numeric($value)) {
            return $value;
        }

        return null;
    }

    /**
     * Transform a boolean.
     */
    protected function transformBoolean($value): ?string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        return null;
    }

    protected function transformObject(mixed $value): ?string
    {
        if (!is_object($value)) {
            return null;
        }

        if ($value instanceof Jsonable) {
            return $value->toJson();
        }

        if ($value instanceof Arrayable) {
            return json_encode($value->toArray(), JSON_THROW_ON_ERROR);
        }

        // Otherwise, if the object doesn't even have a
        // __toString() method, we can't proceed.
        if (!method_exists($value, '__toString')) {
            throw new InvalidArgumentException('Cannot transform this object to JavaScript.');
        }

        return sprintf('\'%s\'', $value);
    }

    /**
     * Transform "null.".
     */
    protected function transformNull(mixed $value): ?string
    {
        if (is_null($value)) {
            return 'null';
        }

        return null;
    }

    public function toHtml(): string
    {
        $string = implode(PHP_EOL, $this->variables);
        $namespaceDeclaration = $this->buildNamespaceDeclaration();

        return sprintf(
            <<<VAR
<script>
%s
</script>
VAR
            ,
            $namespaceDeclaration . $string,
        );
    }

    public function __toString(): string
    {
        return $this->toHtml();
    }

    public function toArray(): array
    {
        return [
            'type' => 'javascript_variables',
            'variables' => $this->variables,
        ];
    }
}
