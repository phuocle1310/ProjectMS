<?php

use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('layout.base');
});
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user-createView', [UserController::class, 'createView'])->name('user.createView');
Route::post('/user-create', [UserController::class, 'create'])->name('user.create');
Route::get('/user-editView/{userId}', [UserController::class, 'editView'])->name('user.editView');
Route::put('/user-edit/{userId}', [UserController::class, 'edit'])->name('user.edit');
Route::delete('/user-delete/{userId}', [UserController::class, 'delete'])->name('user.delete');

Route::get('/user/api', [UserController::class, 'api'])->name('user.api');

// Route table project

Route::get('/project', [UserController::class, 'index'])->name('project.index');
Route::get('/project-createView', [UserController::class, 'createView'])->name('project.createView');
Route::post('/project-create', [UserController::class, 'create'])->name('project.create');

// Route table task

Route::get('/task', [UserController::class, 'index'])->name('task.index');
Route::get('/task-createView', [UserController::class, 'createView'])->name('task.createView');
Route::post('/task-create', [UserController::class, 'create'])->name('task.create');