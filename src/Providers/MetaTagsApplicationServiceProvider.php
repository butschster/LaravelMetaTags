<?php

namespace Butschster\Head\Providers;

use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\Contracts\Packages\ManagerInterface;
use Butschster\Head\MetaTags\Meta;
use Butschster\Head\Packages\Manager;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class MetaTagsApplicationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        if ($this->app->bound('blade.compiler')) {
            $this->registerBladeDirectives();
        }
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
            $meta = new Meta(
                $this->app[ManagerInterface::class],
                $this->app['config']
            );

            return $meta->initialize();
        });
    }

    protected function registerPackageManager()
    {
        $this->app->singleton(ManagerInterface::class, function () {
            return new Manager();
        });
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('meta_tags', function($expression) {
            if (empty($expression)) {
                return "<?php echo \Butschster\Head\Facades\Meta::toHtml(); ?>";
            }

            return "<?php echo \Butschster\Head\Facades\Meta::placement($expression)->toHtml(); ?>";
        });
    }
}