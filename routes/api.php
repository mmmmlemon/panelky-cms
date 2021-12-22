<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getSiteOwnerInfo', [APIController::class, 'getSiteOwnerInfo']);
Route::get('/getOrderTypesInfo', [APIController::class, 'getOrderTypesInfo']);
Route::get('/getProjectsList', [APIController::class, 'getProjectsList']);
Route::get('/getFirstProjectSlug', [APIController::class, 'getFirstProjectSlug']);
Route::get('/getProject/{id}/{type}', [APIController::class, 'getProject']);
Route::get('/getFullProjectList', [APIController::class, 'getFullProjectList']);
Route::get('/getStockImages', [APIController::class, 'getStockImages']);
Route::get('/getAllProjects', [APIController::class, 'getAllProjects']);
Route::post('/setProjectStatus', [APIController::class, 'setProjectStatus']);
Route::get('/getLinks', [APIController::class, 'getLinks']);
Route::get('/getEmail', [APIController::class, 'getEmail']);
Route::get('/getBasicSettings', [APIController::class, 'getBasicSettings']);
Route::get('/getAccessStatus', [APIController::class, 'getAccessStatus']);
Route::get('/getPublicAccessMessage', [APIController::class, 'getPublicAccessMessage']);
Route::get('/getHomeSettings', [APIController::class, 'getHomeSettings']);
Route::get('/getBgColors', [APIController::class, 'getBgColors']);
Route::get('/getAboutSiteText', [APIController::class, 'getAboutSiteText']);
Route::get('/getContacts', [APIController::class, 'getContacts']);
Route::get('/getCookiesMessage', [APIController::class, 'getCookiesMessage']);
Route::get('/checkCookies', [APIController::class, 'checkCookies']);
Route::post('/setCookiesAccepted', [APIController::class, 'setCookiesAccepted']);