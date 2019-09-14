<?php

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

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'backoffice', 'middleware' => ['auth', 'checkIfUserHasBOAccess']], function () {
    Route::get('/', function () {
        return view('backoffice.index');
    })->name('backoffice.index');
    Route::resource('permission', 'backoffice\PermissionController');
    Route::resource('user', 'backoffice\UserController');
    Route::resource('tag', 'backoffice\TagController');
    Route::resource('post', 'backoffice\PostController');
    Route::resource('file', 'backoffice\FileController');
});
Auth::routes();

