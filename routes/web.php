<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;

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


Auth::routes();

// тесты
Route::get('/saveJson', [TestController::class, 'saveJson'])->where('any', '.*');
Route::get('/readJson', [TestController::class, 'readJson'])->where('any', '.*');

//ссылка на любую страницу ведет на страницу index, которая показывает vue-router
Route::get('/{any}', [HomeController::class, 'index'])->where('any','.*');
