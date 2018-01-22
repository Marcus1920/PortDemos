<?php

namespace App\Providers;

use App\services\TaskNoteService;
use Illuminate\Support\ServiceProvider;

class TaskNoteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TaskNoteService::class, function ($app) {
            return new TaskNoteService();
        });

    }
}
