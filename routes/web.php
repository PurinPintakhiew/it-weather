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

Route::get('/',[SensorController::class,'show']);
Route::post('weather-add',[SensorController::class,'writeData'])->name('add');
Route::get('weather-save',[SensorController::class,'saveData'])->name('save');
Route::get('weather-pm24',[SensorController::class,'pmAvg'])->name('avg');

Route::get('chartPm',[ChartController::class,'chartData']);
Route::get('chartData',[ChartController::class,'chartSelect']);
Route::post('chartData',[ChartController::class,'dataSelect'])->name('see');

Route::post('test', function()
{
    return 'Success! ajax in laravel 5';
});
Route::get('getData', function()
{
    return view('getMqtt');
});
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('is_admin');

