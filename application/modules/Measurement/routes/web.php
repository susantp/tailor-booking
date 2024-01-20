<?php

use Illuminate\Support\Facades\Route;

Route::get('measurement', '\Modules\Measurement\Http\Controllers\MeasurementController@index');