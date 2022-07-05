<?php

use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\OfficeController;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('/office', OfficeController::class)
        ->except(['create', 'edit']);

    Route::get('/getAuth', [UserController::class, 'getAuth']);
    Route::get('/locations', [LocationController::class, 'index']);
    Route::get('/user/office', [OfficeController::class, 'getByUserId']);

    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/team', [TeamController::class, 'store']);
});

