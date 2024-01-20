<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckPermission;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(CheckPermission $checkPermission) {
//        $info = $checkPermission->module_info(); //# yo function ya bata call garda chai error aaucha
        if (\Request::is('shell/*')) { //# :only for the backend section.
            \View::composer('*', function($view) use($checkPermission) {
                $info = $checkPermission->module_info();
                $view->with('active_module_id', $info['active_module_id']);
                $view->with('active_module_name', $info['active_module_name']);
                $view->with('all_parent_modules', $info['all_parent_modules']);
                $view->with('all_child_modules', $info['all_child_modules']);
                $view->with('segment', $info['segment']);
                $view->with('activeModulePermission', $info['activeModulePermission']);
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //# In AppServiceProvider register() method register the middleware as a singleton:
        //# $this->app->singleton('App\Http\Middleware\CheckPermission');
        //# And if you need the information for the user in any of the controllers use the Dependency Injection to get it.
        //# URL: https://laracasts.com/discuss/channels/general-discussion/pass-data-from-middleware-to-controllers
        $this->app->singleton('App\Http\Middleware\CheckPermission');
    }

}
