<?php

namespace Modules\Measurement\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckPermission;

class MeasurementServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $this->loadViewsFrom(__DIR__.'/../resources/views', '\Modules\Measurement');
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
