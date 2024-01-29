<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('measurement', 'MeasurementController@index');
Route::post('send-email', 'MeasurementController@sendEmail');