<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TaskOwnerService;

class TaskOwnerServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind(TaskOwnerService::class, function ($app) {
            return new TaskOwnerService();
        });
    }
}
