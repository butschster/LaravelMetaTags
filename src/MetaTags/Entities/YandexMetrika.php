<?php

namespace Butschster\Head\MetaTags\Entities;

use BadMethodCallException;
use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\MetaTags\Entities\Builders\YandexMetrikaCounterBuilder;
use Butschster\Head\MetaTags\Meta;

/**
 * @mixin YandexMetrikaCounterBuilder
 */
class YandexMetrika implements TagInterface, \Stringable
{
    protected YandexMetrikaCounterBuilder $builder;

    public function __construct(string $counterId)
    {
        $this->builder = new YandexMetrikaCounterBuilder($counterId);
    }

    public function getPlacement(): string
    {
        return Meta::PLACEMENT_FOOTER;
    }

    public function __call(string $method, array $arguments): YandexMetrika
    {
        if (!method_exists($this->builder, $method)) {
            throw new BadMethodCallException(
                sprintf(
                    'Method %s::%s does not exist.',
                    $this->builder::class,
                    $method,
                ),
            );
        }

        call_user_func_array([$this->builder, $method], $arguments);

        return $this;
    }

    public function toHtml(): string
    {
        return (string)$this->builder;
    }

    public function __toString(): string
    {
        return $this->toHtml();
    }

    public function toArray(): array
    {
        return [
                'type' => 'yandex_metrika',
            ] + $this->builder->toArray();
    }
}
