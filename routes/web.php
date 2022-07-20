<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicUserController;

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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/admin',[AdminController::class,'index'])->name('admin');
Route::get('/user_home',[PublicUserController::class,'index'])->name('user_index')->middleware('auth');
Route::get('/feed',[PublicUserController::class,'feed'])->name('feed')->middleware('auth');
Route::post('/user_create',[PublicUserController::class,'create'])->name('user_create');
Route::post('/user_search',[PublicUserController::class,'search'])->name('user_search')->middleware('auth');
Route::post('/user_follow',[PublicUserController::class,'followAUser'])->name('follow')->middleware('auth');
Route::post('/user_comment',[PublicUserController::class,'comment'])->name('user_comment');
Route::delete('/user_post',[PublicUserController::class,'del_post'])->name('del_post');