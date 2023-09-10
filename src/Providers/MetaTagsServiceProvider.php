<?php

namespace Butschster\Head\Providers;

use Illuminate\Support\ServiceProvider;

class MetaTagsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->app->register(MetaTagsBootstrapServiceProvider::class);
        }

        /**
         * @psalm-suppress UndefinedInterfaceMethod
         */
        if (!$this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__ . '/../../config/meta_tags.php', 'meta_tags');
        }
    }
}
