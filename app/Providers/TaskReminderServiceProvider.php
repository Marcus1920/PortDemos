<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TaskReminderService;

class TaskReminderServiceProvider extends ServiceProvider
{

    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind(TaskReminderService::class,  function($app)
        {
            return new TaskReminderService();
        });
    }
}
