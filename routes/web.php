<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\HomeController;
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

Route::get('/weather',[SensorController::class,'show']);
Route::post('weather-add',[SensorController::class,'writeData'])->name('add');
Route::get('weather-save',[SensorController::class,'saveData'])->name('save');

Route::get('chartPm',[ChartController::class,'chartData']);

Route::get('chart',function(){
    return view('chartAvg');
});

Route::post('test', function()
{
    return 'Success! ajax in laravel 5';
});
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('is_admin');

