<?php

namespace Butschster\Head\Providers;

use Illuminate\Support\ServiceProvider;

class MetaTagsServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->app->register(MetaTagsBootstrapServiceProvider::class);
        }

        if (!$this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__ . '/../../config/meta_tags.php', 'meta_tags');
        }
    }
}