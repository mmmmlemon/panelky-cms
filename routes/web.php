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
Route::post('/admin/setNewOrderForHomeProjects', [AdminController::class, 'setNewOrderForHomeProjects']);
Route::post('/admin/editLink', [AdminController::class, 'editLink']);
Route::post('/admin/addLink', [AdminController::class, 'addLink']);
Route::post('/admin/deleteLink', [AdminController::class, 'deleteLink']);
Route::post('/admin/setNewOrderForLinks', [AdminController::class, 'setNewOrderForLinks']);
Route::post('/admin/editEmail', [AdminController::class, 'editEmail']);
Route::post('/admin/saveBasicSettings', [AdminController::class, 'saveBasicSettings']);
Route::post('/admin/saveHomeSettings', [AdminController::class, 'saveHomeSettings']);
Route::post('/admin/saveBgColors', [AdminController::class, 'saveBgColors']);
Route::post('/admin/saveAboutSiteText', [AdminController::class, 'saveAboutSiteText']);
Route::post('/admin/saveProjectSlide', [AdminController::class, 'saveProjectSlide']);
Route::post('/admin/deleteProjectSlide', [AdminController::class, 'deleteProjectSlide']);
Route::post('/admin/setNewOrderForSlides', [AdminController::class, 'setNewOrderForSlides']);
Route::post('/admin/saveSlideChanges', [AdminController::class, 'saveSlideChanges']);
Route::get('/admin/getSocialMediaLibrary', [AdminController::class, 'getSocialMediaLibrary']);
Route::post('/admin/addContact', [AdminController::class, 'addContact']);
Route::post('/admin/editContact', [AdminController::class, 'editContact']);
Route::post('/admin/deleteContact', [AdminController::class, 'deleteContact']);
Route::post('/admin/setNewOrderForContacts', [AdminController::class, 'setNewOrderForContacts']);


Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/{any}', [AdminController::class, 'index']);
Route::get('/admin/{any}/{id}', [AdminController::class, 'index']);

//ссылка на любую страницу ведет на страницу index, которая показывает vue-router
Route::get('{any}', [HomeController::class, 'index'])->where('any', '.*');

