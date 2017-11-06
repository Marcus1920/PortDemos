<?php

namespace App\Providers;

use App\services\CaseActivityService;
use Illuminate\Support\ServiceProvider;

class CaseActivityProvider extends ServiceProvider
{

    public function register()
    {

        $this->app->bind(CaseActivityService::class,function($app){
            return new CaseActivityService();
        });
    }
}
