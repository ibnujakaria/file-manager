<?php

namespace Ibnujakaria\FileManager;

use Illuminate\Support\ServiceProvider;

class FileManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'file-manager');
        
        $this->publishes([
            __DIR__.'/../config/file-manager.php' => config_path('file-manager.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/file-manager.php', 'file-manager'
        );

        include __DIR__ . '/../routes/routes.php';

        $this->app->make(FileManagerController::class);
    }
}
