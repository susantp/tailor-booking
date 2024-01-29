<?php

namespace Modules\Measurement\Providers;

use Illuminate\Support\ServiceProvider;

class MeasurementServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'measurement');
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
    }

}
