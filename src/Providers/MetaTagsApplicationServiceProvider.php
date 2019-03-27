<?php

namespace Butschster\Head\Providers;

use Butschster\Head\MetaTags\Meta;
use Butschster\Head\MetaTags\MetaInterface;
use Butschster\Head\Packages\Manager;
use Butschster\Head\Packages\ManagerInterface;
use Illuminate\Support\ServiceProvider;

class MetaTagsApplicationServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {

    }

    public function register()
    {
        $this->registerPackageManager();
        $this->registerMeta();

        $this->packages();
    }

    protected function packages()
    {
        //
    }

    protected function registerMeta(): void
    {
        $this->app->singleton(MetaInterface::class, function () {
            return new Meta($this->app[ManagerInterface::class]);
        });
    }

    protected function registerPackageManager()
    {
        $this->app->singleton(ManagerInterface::class, function () {
            return new Manager();
        });
    }

    /**
     * Get the services provided by the provider.
     * @return string[]
     */
    public function provides()
    {
        return [
            MetaInterface::class,
            ManagerInterface::class,
        ];
    }
}