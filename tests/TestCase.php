<?php


namespace Butschster\Tests;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\MetaTags\Meta;
use Butschster\Head\Packages\Manager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Mockery as m;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();

        m::close();
    }

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @return MetaInterface
     */
    protected function makeMetaTags(): MetaInterface
    {
        return new Meta(new Manager());
    }

    /**
     * @return Application|m\MockInterface
     */
    protected function makeApplication()
    {
        return m::spy(Application::class);
    }

    /**
     * @return TagInterface|m\MockInterface
     */
    protected function makeTag()
    {
        return m::mock(TagInterface::class);
    }

    /**
     * @param string|array $expectations
     * @param Htmlable $object
     *
     * @return $this
     */
    protected function assertHtmlableContains($expectations, Htmlable $object)
    {
        if (!is_array($expectations)) {
            $expectations = [$expectations];
        }

        $html = $object->toHtml();

        foreach ($expectations as $expected) {
            $this->assertStringContainsString($expected, $html);
        }

        return $this;
    }

    /**
     * @param string|array $expectations
     * @param Htmlable $object
     *
     * @return $this
     */
    protected function assertHtmlableNotContains($expectations, Htmlable $object)
    {
        if (!is_array($expectations)) {
            $expectations = [$expectations];
        }

        $html = $object->toHtml();

        foreach ($expectations as $expected) {
            $this->assertStringNotContainsString($expected, $html);
        }

        return $this;
    }

    /**
     * @param string|array $expectations
     * @param Htmlable $object
     *
     * @return $this
     */
    protected function assertHtmlableEquals($expectations, Htmlable $object)
    {
        if (!is_array($expectations)) {
            $expectations = [$expectations];
        }

        $html = $object->toHtml();

        foreach ($expectations as $expected) {
            $this->assertEquals($expected, $html);
        }

        return $this;
    }

    /**
     * @param string|array $expectations
     * @param Htmlable $object
     *
     * @return $this
     */
    protected function assertHtmlableNotEquals($expectations, Htmlable $object)
    {
        if (!is_array($expectations)) {
            $expectations = [$expectations];
        }

        $html = $object->toHtml();

        foreach ($expectations as $expected) {
            $this->assertEquals($expected, $html);
        }

        return $this;
    }
}