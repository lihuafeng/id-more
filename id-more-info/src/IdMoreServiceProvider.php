<?php

namespace IdMoreInfo;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;

class IdMoreServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot()
    {
        $this->app->bind('idinfo', function () {
            return new IdCardInfo();
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        return ['idinfo'];
    }

}
