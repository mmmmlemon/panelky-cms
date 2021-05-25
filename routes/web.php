<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
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
Route::post('/submitForm', [TestController::class, 'submitForm'])->where('any', '.*');
Route::get('/newProject', [TestController::class, 'addNewProject'])->where('any', '.*');

//админ
Route::post('/admin/saveSiteOwnerInfo', [AdminController::class, 'saveSiteOwnerInfo']);
Route::post('/admin/saveProjectBasic', [AdminController::class, 'saveProjectBasic']);
Route::post('/admin/saveProjectImages', [AdminController::class, 'saveProjectImages']);
Route::post('/admin/deleteImageFromProject', [AdminController::class, 'deleteImageFromProject']);
Route::post('/admin/addNewProject', [AdminController::class, 'addNewProject']);
Route::post('/admin/saveImageToTemp', [AdminController::class, 'saveImageToTemp']);
Route::post('/admin/removeFolderFromTemp', [AdminController::class, 'removeFolderFromTemp']);
Route::post('/admin/deleteProject', [AdminController::class, 'deleteProject']);

Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/{any}', [AdminController::class, 'index']);
Route::get('/admin/{any}/{id}', [AdminController::class, 'index']);

//ссылка на любую страницу ведет на страницу index, которая показывает vue-router
Route::get('{any}', [HomeController::class, 'index'])->where('any', '.*');

