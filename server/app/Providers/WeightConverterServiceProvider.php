<?php

namespace App\Providers;

use App\Service\WeightConverterService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class WeightConverterServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WeightConverterService::class, function ($app) {
            return new WeightConverterService();
        });
    }
}
