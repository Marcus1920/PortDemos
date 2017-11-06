<?php

namespace App\Providers;

use App\services\CaseOwnerService;
use Illuminate\Support\ServiceProvider;

class CaseOwnerServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(CaseOwnerService::class,function($app){
            return new CaseOwnerService(
                $app->make('App\services\CaseResponderService'),
                $app->make('App\services\CaseActivityService'));
        });
    }

}
