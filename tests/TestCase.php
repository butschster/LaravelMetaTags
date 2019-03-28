<?php


namespace Butschster\Tests;

use Butschster\Head\Contracts\MetaTags\Entities\TagInterface;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\MetaTags\Meta;
use Butschster\Head\Packages\Manager;
use Illuminate\Contracts\Foundation\Application;
use Mockery as m;
use Symfony\Component\VarDumper\VarDumper;

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
}