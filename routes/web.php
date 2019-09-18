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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    Route::resource('language', 'backoffice\LanguageController');
    Route::resource('article', 'backoffice\ArticleController');



    Route::get('/updateStatus/{id}/{table}/{column}/{prevStatus}/{permission}',
        function ($id, $table, $column, $prevStatus, $permission) {
            if (Auth::user()->hasPermissionTo($permission)){
                DB::table($table)->where($column, $id)->update(['STATUS' => !$prevStatus]);
                return redirect()->back();
            }
        abort(403);

    })->name('status.update');
});
Auth::routes();


Auth::routes();

