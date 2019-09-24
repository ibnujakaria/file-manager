<?php

namespace Ibnujakaria\FileManager;

use Illuminate\Support\ServiceProvider;
use Ibnujakaria\FileManager\Http\Controllers\FileManagerController;

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

        $this->publishes([
            __DIR__.'/../../public/file-manager.js' => public_path('file-manager/file-manager.js'),
        ], 'public');
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

        $this->app->bind('file-manager', function () {
            return new FileManagerBase();
        });

        $this->app->make(FileManagerController::class);
    }
}
