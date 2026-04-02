<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectRoleController;
use App\Http\Controllers\TaskController;

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

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/role/index', [RoleController::class, 'index'])->name('role-index');
Route::post('/role/create', [RoleController::class, 'create'])->name('role-create');
Route::post('/role/update/{id}', [RoleController::class, 'update'])->name('role-update');
Route::get('/role/delete/{id}', [RoleController::class, 'delete'])->name('role-delete');
Route::get('/role/action/get/{id}', [RoleController::class, 'getAction'])->name('get-role-action');
Route::post('/role/action/update/{id}', [RoleController::class, 'updateAction'])->name('update-role-actions');


Route::get('/user/index', [UserController::class, 'index'])->name('user-index');
Route::post('/user/create', [UserController::class, 'create'])->name('user-create');
Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user-update');
Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('user-delete');
Route::get('/show/user/assign/{id}',[UserController::class, 'showUserAssign'])->name('show-user-assign');
Route::post('/store/user/assign/{id}',[UserController::class, 'storeUserAssign'])->name('store-user-assign');
Route::get('/user/active/toggle/{id}/{status}',[UserController::class, 'setActiveToggle'])->name('set-active-toggle');

// Project Routes Start

Route::get('/project/index', [ProjectController::class, 'index'])->name('project-index');
Route::post('/project/create', [ProjectController::class, 'create'])->name('project-create');
Route::post('/project/update/{id}', [ProjectController::class, 'update'])->name('project-update');
Route::get('/project/delete/{id}', [ProjectController::class, 'delete'])->name('project-delete');
Route::get('/project/view/{id}', [ProjectController::class, 'view'])->name('project-view');

// Project Role Routes Start

Route::get('/project/role/index', [ProjectRoleController::class, 'index'])->name('project-role-index');
Route::post('/project/role/create', [ProjectRoleController::class, 'create'])->name('project-role-create');
Route::post('/project/role/update/{id}', [ProjectRoleController::class, 'update'])->name('project-role-update');
Route::get('/project/role/delete/{id}', [ProjectRoleController::class, 'delete'])->name('project-role-delete');

// Client Routes Start

Route::get('/client/index', [ClientController::class, 'index'])->name('client-index');
Route::post('/client/create', [ClientController::class, 'create'])->name('client-create');
Route::post('/client/update/{id}', [ClientController::class, 'update'])->name('client-update');
Route::get('/client/delete/{id}', [ClientController::class, 'delete'])->name('client-delete');

// Task Routes Start

Route::get('/task/index', [TaskController::class, 'index'])->name('task-index');
Route::post('/task/create', [TaskController::class, 'create'])->name('task-create');
Route::post('/task/update/{id}', [TaskController::class, 'update'])->name('task-update');
Route::get('/task/delete/{id}', [TaskController::class, 'delete'])->name('task-delete');

// Invoice Routes Start

Route::get('/invoice/index', [InvoiceController::class, 'index'])->name('invoice-index');
Route::post('/invoice/create', [InvoiceController::class, 'create'])->name('invoice-create');
Route::post('/invoice/update/{id}', [InvoiceController::class, 'update'])->name('invoice-update');
Route::get('/invoice/delete/{id}', [InvoiceController::class, 'delete'])->name('invoice-delete');

