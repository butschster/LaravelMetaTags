<?php

namespace Butschster\Head\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meta-tags:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the MetaTags package resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
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
     *
     * @return void
     */
    protected function registerServiceProvider()
    {
        $namespace = Str::replaceLast('\\', '', $this->getLaravel()->getNamespace());

        $config = file_get_contents(config_path('app.php'));
        $line = "{$namespace}\Providers\MetaTagsServiceProvider::class";

        if (Str::contains($config, $line)) {
            $this->warn('Config config/app.php contains MetaTagsServiceProvider. Registration canceled!');
            return;
        }

        file_put_contents(config_path('app.php'), str_replace(
            "{$namespace}\\Providers\EventServiceProvider::class,".PHP_EOL,
            "{$namespace}\\Providers\EventServiceProvider::class,".PHP_EOL."        {$line},".PHP_EOL,
            $config
        ));
    }

    /**
     * Set the proper application namespace on the installed files.
     *
     * @return void
     */
    protected function setAppNamespace()
    {
        $this->setAppNamespaceOn(
            app_path('Providers/MetaTagsServiceProvider.php'),
            $this->getLaravel()->getNamespace()
        );
    }

    /**
     * Set the namespace on the given file.
     *
     * @param  string  $file
     * @param  string  $namespace
     * @return void
     */
    protected function setAppNamespaceOn($file, $namespace)
    {
        file_put_contents($file, str_replace(
            'App\\',
            $namespace,
            file_get_contents($file)
        ));
    }
}