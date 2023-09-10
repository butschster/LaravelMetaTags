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
    public function boot(): void
    {
        if ($this->app->bound('blade.compiler')) {
            $this->registerBladeDirectives();
        }
    }

    public function register(): void
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
            $manager = $this->app->get(ManagerInterface::class);
            \assert($manager instanceof ManagerInterface);

            $config = $this->app->get('config');

            $meta = new Meta(
                $manager,
                $config
            );

            return $meta->initialize();
        });
    }

    protected function registerPackageManager(): void
    {
        $this->app->singleton(ManagerInterface::class, static fn() => new Manager());
    }

    protected function registerBladeDirectives(): void
    {
        Blade::directive('meta_tags', static function ($expression) {
            if (empty($expression)) {
                return '<?php echo ' . \Butschster\Head\Facades\Meta::class . '::toHtml(); ?>';
            }
            return sprintf('<?php echo ' . \Butschster\Head\Facades\Meta::class . '::placement(%s)->toHtml(); ?>', $expression);
        });
    }
}
