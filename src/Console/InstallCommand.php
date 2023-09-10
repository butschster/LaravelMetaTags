<?php

namespace Butschster\Head\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    protected $signature = 'meta-tags:install';
    
    protected $description = 'Install all of the MetaTags package resources';

    public function handle(): void
    {
        $this->comment('Publishing MetaTags Service Provider...');
        $this->callSilent('vendor:publish', ['--tag' => 'meta-tags-provider']);

        $this->comment('Publishing MetaTags config...');
        $this->callSilent('vendor:publish', ['--tag' => 'meta-tags-config']);

        $this->comment('Registering Service Provider in [config/app.php] ..');
        $this->registerServiceProvider();
        $this->setAppNamespace();

        $this->info('MetaTags resources installed successfully.');
    }

    /**
     * Register the Nova service provider in the application configuration file.
     */
    protected function registerServiceProvider(): void
    {
        $namespace = Str::replaceLast('\\', '', $this->getLaravel()->getNamespace());

        /** @psalm-suppress UndefinedFunction */
        $config = file_get_contents(config_path('app.php'));
        $line = $namespace . '\Providers\MetaTagsServiceProvider::class';

        if (Str::contains($config, $line)) {
            $this->warn('Config config/app.php contains MetaTagsServiceProvider. Registration canceled!');
            return;
        }

        /** @psalm-suppress UndefinedFunction */
        file_put_contents(config_path('app.php'), str_replace(
            $namespace . '\Providers\EventServiceProvider::class,'.PHP_EOL,
            $namespace . '\Providers\EventServiceProvider::class,'.PHP_EOL.sprintf('        %s,', $line).PHP_EOL,
            $config
        ));
    }

    /**
     * Set the proper application namespace on the installed files.
     */
    protected function setAppNamespace(): void
    {
        /** @psalm-suppress UndefinedFunction */
        $this->setAppNamespaceOn(
            app_path('Providers/MetaTagsServiceProvider.php'),
            $this->getLaravel()->getNamespace()
        );
    }

    /**
     * Set the namespace on the given file.
     */
    protected function setAppNamespaceOn(string $file, string $namespace): void
    {
        file_put_contents($file, str_replace(
            'App\\',
            $namespace,
            file_get_contents($file)
        ));
    }
}
