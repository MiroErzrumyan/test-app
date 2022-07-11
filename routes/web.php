<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

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


Route::get('/member/register/{id}', function ($id) {
    return view('memberLogin',['id' => $id]);
})->name('loginMember');

Route::post('/member/setPassword', [UserController::class, 'setMemberPassword'])->name('setPassword');

Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '.*')->name('welcome');
