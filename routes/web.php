<?php

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

Route::get('/', function () {
    return view('Auth/Login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/role/index', [App\Http\Controllers\RoleController::class, 'index'])->name('role-index');
Route::post('/role/create', [App\Http\Controllers\RoleController::class, 'create'])->name('role-create');
Route::post('/role/update/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('role-update');
Route::get('/role/delete/{id}', [App\Http\Controllers\RoleController::class, 'delete'])->name('role-delete');
Route::get('/role/action/get/{id}', [App\Http\Controllers\RoleController::class, 'getAction'])->name('get-role-action');
Route::post('/role/action/update/{id}', [App\Http\Controllers\RoleController::class, 'updateAction'])->name('update-role-actions');


Route::get('/user/index', [App\Http\Controllers\UserController::class, 'index'])->name('user-index');
Route::post('/user/create', [App\Http\Controllers\UserController::class, 'create'])->name('user-create');
Route::post('/user/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user-update');
Route::get('/show/user/assign/{id}',[App\Http\Controllers\UserController::class, 'showUserAssign'])->name('show-user-assign');
Route::post('/store/user/assign/{id}',[App\Http\Controllers\UserController::class, 'storeUserAssign'])->name('store-user-assign');
