<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

//Route::get('pop', array('uses' => 'Barryvdh\Elfinder\ElfinderController@showPopup','as'=>'pop'));
//Auth::routes();
//#AUTHENTICATION ROUTE STARTS >>
Route::get('shell/login', 'CustomAuthentication\CustomAuthenticationController@loginPage')->name('BACKEND-LOGIN');
Route::post('shell/check-login', 'CustomAuthentication\CustomAuthenticationController@checkLogin')->name('BACKEND-CHECK-LOGIN');
//Route::get('shell/dashboard', 'Dashboard\DashboardController@dashboard')->name('BACKEND-DASHBOARD');
Route::get('shell/logout', 'CustomAuthentication\CustomAuthenticationController@logout')->name('BACKEND-LOGOUT');
Route::post('shell/forgot-password', 'CustomAuthentication\CustomAuthenticationController@postForgotPasswordRequest')->name('BACKEND-POST-FORGOT-PASSWORD-REQUEST');
Route::get('shell/process-forgot-password/{passwordToken}', 'CustomAuthentication\CustomAuthenticationController@processForgotPasswordForm')->name('BACKEND-FORM-PROCESS-FORGOT-PASSWORD');
Route::post('shell/post-process-forgot-password/{passwordToken}', 'CustomAuthentication\CustomAuthenticationController@postProcessForgotPassword')->name('BACKEND-POST-PROCESS-FORGOT-PASSWORD');
//#AUTHENTICATION ROUTE ENDS <<
//# shell routes >>
$router->group([
    'prefix' => 'shell',
    'namespace' => 'Backend',
    'middleware' => ['auth', 'checkpermission'],
        ], function() {
    Route::get('dashboard', 'DashboardController@index')->name('BACKEND-DASHBOARD');
    Route::get('/', function() {
        return redirect('shell/dashboard');
    });
    //#modules array list >>
    $modules_arr = array(
        'scroll' => 'Scroll',
        'hire' => 'Hire',
        'retail' => 'Retail',
        'brand' => 'Brand',
        'activity' => 'Activity',
        'advertisement' => 'Advertisement',
        'affiliates' => 'Affiliates',
        'banner' => 'Banner',
        'category' => 'Category',
        'client-data' => 'ClientData',
        'suits' => 'Suit',
        'content' => 'Content',
        'faqs' => 'Faqs',
        'gallery' => 'Gallery',
        'guide' => 'Guide',
        'inquiry' => 'Inquiry',
        'menu' => 'Menu',
        'module' => 'Module',
        'news' => 'News',
        'role' => 'Role',
        'rolemodule' => 'RoleModule',
        'setting' => 'Setting',
        'testimonial' => 'Testimonial',
        'user' => 'User',
    );
    foreach ($modules_arr as $route => $controller) {
//        Route::resource($route, $controller . 'Controller', ['except' => 'show']);
        Route::resource($route, $controller . 'Controller');
        Route::get($route . '/changeStatus/{id}/{status}', array('uses' => $controller . 'Controller@changeStatus'));
    }
    
    
//    Route::post('accommodation/getLocationDrop', array('uses' => 'AccommodationController@getLocationDrop'));
//    Route::post('accommodation/getParentLocationDrop', array('uses' => 'AccommodationController@getParentLocationDrop'));
    Route::post('category/getCategoryDrop', array('uses' => 'CategoryController@getCategoryDrop'));
    Route::post('scroll/getProductDrop', array('uses' => 'ScrollController@getProductDrop'));

    Route::get('resetPassword', array('as' => 'reset.password', 'uses' => 'DashboardController@resetPassword'));
    Route::post('resetPasswordAction', array('as' => 'reset.password.action', 'uses' => 'DashboardController@resetPasswordAction'));
    Route::post('rolemodule/manage', array('as' => '', 'uses' => 'RoleModuleController@manage'));

    Route::post('menu/check_slug', array('uses' => 'MenuController@check_slug'));
    Route::post('menu/getContentDrop', array('uses' => 'MenuController@getContentDrop'));
    Route::post('menu/getCategoryDrop', array('uses' => 'MenuController@getCategoryDrop'));
    Route::get('file', array('uses' => 'FileController@index'));
});
//# shell routes <<
//# for backend missing routes exception
Route::any('shell/{query}', function() {
    return redirect('/shell?err=err');
})->where('query', '.*');



$router->group([
    'namespace' => 'Frontend'], function() {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);
//    Route::get('/{acco}/{id?}/{name?}', ['uses' => 'AccommodationController@index'])->where('acco', 'hotel|lodges|restaurant|home-stay');
    Route::post('process_form', array('uses' => 'FormProcessController@index'));
    Route::post('process_send_data_form', array('uses' => 'FormProcessController@process_send_data_form'));
    Route::any('/swap/{method?}/{query?}', ['uses' => 'SwapController@index', 'as' => 'swap']); //# test controller
    //# for frontend missing routes exception
    if (!Request::is('elfinder/connector') && !Request::is('elfinder/ckeditor')) {
        Route::any('{query}/{param?}', ['uses' => 'PageController@index', 'as' => 'page'])->where('query', '.*');
    }
});