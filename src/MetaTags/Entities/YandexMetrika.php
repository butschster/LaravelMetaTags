<?php

namespace Butschster\Head\MetaTags\Entities;

use BadMethodCallException;
use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\MetaTags\Entities\Builders\YandexMetrikaCounterBuilder;
use Butschster\Head\MetaTags\Meta;

/**
 * @mixin YandexMetrikaCounterBuilder
 */
class YandexMetrika implements TagInterface
{
    /**
     * @var YandexMetrikaCounterBuilder
     */
    protected $builder;

    /**
     * @param string $counterId
     */
    public function __construct(string $counterId)
    {
        $this->builder = new YandexMetrikaCounterBuilder($counterId);
    }

    /**
     * @return string
     */
    public function getPlacement(): string
    {
        return Meta::PLACEMENT_FOOTER;
    }

    /**
     * @param string $method
     * @param array $arguments
     *
     * @return YandexMetrika
     */
    public function __call($method, $arguments)
    {
        if (!method_exists($this->builder, $method)) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.', get_class($this->builder), $method
            ));
        }

        call_user_func_array([$this->builder, $method], $arguments);

        return $this;
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return (string)$this->builder;
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
            'type' => 'yandex_metrika',
        ] + $this->builder->toArray();
    }
}
