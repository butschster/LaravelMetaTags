<?php

namespace Butschster\Head\Providers;

use Butschster\Head\Console\InstallCommand;
use Illuminate\Support\ServiceProvider;

class MetaTagsBootstrapServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }
    }

    public function register(): void
    {
        $this->commands([
            InstallCommand::class,
        ]);
    }

    protected function registerPublishing(): void
    {
        /** @psalm-suppress UndefinedFunction */
        $this->publishes([
            __DIR__.'/../Console/stubs/MetaTagsServiceProvider.stub' => app_path('Providers/MetaTagsServiceProvider.php'),
        ], 'meta-tags-provider');

        /** @psalm-suppress UndefinedFunction */
        $this->publishes([
            __DIR__.'/../../config/meta_tags.php' => config_path('meta_tags.php'),
        ], 'meta-tags-config');
    }
}
