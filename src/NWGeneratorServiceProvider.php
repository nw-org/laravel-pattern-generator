<?php

namespace NuWorks\Generator;

use Illuminate\Support\ServiceProvider;

class NWGeneratorServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 * 
	 * @return  void
	 */
    public function boot()
    {
        $this->publishes([
            __DIR__ .'/Config/Configuration.php' => config_path('nw_generator.php')
        ]);
    }

	/**
	 * Register the application services.
	 * 
	 * @return  void
	 */
    public function register()
    {
        $this->registerRepositoryGenerator();
    }

	/**
	 * Register the make:repository command.
	 * 
	 * @return  void
	 */
    public function registerRepositoryGenerator()
    {
        $this->app->singleton('command.nuworks.repository', function($app) {
            return $app['NuWorks\Generator\Commands\MakeRepositoryCommand'];
        });

        $this->commands('command.nuworks.repository');
    }
}