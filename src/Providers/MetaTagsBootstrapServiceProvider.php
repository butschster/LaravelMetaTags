<?php

namespace Butschster\Head\Providers;

use Butschster\Head\Console\InstallCommand;
use Illuminate\Support\ServiceProvider;

class MetaTagsBootstrapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            InstallCommand::class,
        ]);
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__.'/../Console/stubs/MetaTagsServiceProvider.stub' => app_path('Providers/MetaTagsServiceProvider.php'),
        ], 'meta-tags-provider');

        $this->publishes([
            __DIR__.'/../../config/meta_tags.php' => config_path('meta_tags.php'),
        ], 'meta-tags-config');
    }
}