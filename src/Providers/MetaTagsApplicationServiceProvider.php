<?php

namespace Butschster\Head\Providers;

use Butschster\Head\MetaTags\Meta;
use Butschster\Head\MetaTags\MetaInterface;
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
     *
     * @return void
     */
    public function boot()
    {

    }

    public function register()
    {
        $this->registerMeta();
    }

    protected function registerMeta(): void
    {
        $this->app->singleton(MetaInterface::class, function () {
            return new Meta();
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
        ];
    }
}