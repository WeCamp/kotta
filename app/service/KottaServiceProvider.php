<?php

namespace Service;

use Illuminate\Support\ServiceProvider;

class KottaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Service\ConversionService', function($app)
            {
                return new ConversionService();
            });
    }
}