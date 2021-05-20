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
Route::get('/getProjectsList', [APIController::class, 'getProjectsList']);
Route::get('/getFirstProjectSlug', [APIController::class, 'getFirstProjectSlug']);
Route::get('/getProject/{id}/{type}', [APIController::class, 'getProject']);
Route::get('/getFullProjectList', [APIController::class, 'getFullProjectList']);