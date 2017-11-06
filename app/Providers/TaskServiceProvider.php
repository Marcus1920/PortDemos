<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\services\TaskService;

class TaskServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {

        $this->app->bind(TaskService::class,function($app){
            return new TaskService(
                $app->make('App\services\TaskOwnerService')
                );
        });
    }
}
