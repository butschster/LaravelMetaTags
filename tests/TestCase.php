<?php


namespace Butschster\Tests;

use Butschster\Head\MetaTags\Meta;
use Butschster\Head\MetaTags\MetaInterface;
use Butschster\Head\MetaTags\TagInterface;
use Illuminate\Contracts\Foundation\Application;
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
        return new Meta();
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
}