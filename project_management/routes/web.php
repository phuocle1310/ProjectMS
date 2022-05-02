<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
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

// Route Authentication

Route::get('/login', [AuthController::class, 'index'])->name('login.index');
Route::post('/login', [AuthController::class, 'processLogin'])->name('process.login');

Route::group([
    'middleware'=> 'auth'
], function() {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        return view('layout.base');
    })->name('home');
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user-createView', [UserController::class, 'createView'])->name('user.createView');
    Route::post('/user-create', [UserController::class, 'create'])->name('user.create');
    Route::get('/user-editView/{userId}', [UserController::class, 'editView'])->name('user.editView');
    Route::put('/user-edit/{userId}', [UserController::class, 'edit'])->name('user.edit');
    Route::delete('/user-delete/{userId}', [UserController::class, 'delete'])->name('user.delete');

    Route::get('/user/api', [UserController::class, 'api'])->name('user.api');

    // Route table project

    Route::get('/project', [ProjectController::class, 'index'])->name('project.index');
    Route::get('/project-createView', [ProjectController::class, 'createView'])->name('project.createView');
    Route::post('/project-create', [ProjectController::class, 'create'])->name('project.create');
    Route::get('/project-editView/{projectId}', [ProjectController::class, 'editView'])->name('project.editView');
    Route::put('/project-edit/{projectId}', [ProjectController::class, 'edit'])->name('project.edit');
    Route::delete('/project-delete/{projectId}', [ProjectController::class, 'delete'])->name('project.delete');

    Route::get('/project/api', [ProjectController::class, 'api'])->name('project.api');

    // Route table task

    Route::get('/task', [TaskController::class, 'index'])->name('task.index');
    Route::get('/task-createView', [TaskController::class, 'createView'])->name('task.createView');
    Route::post('/task-create', [TaskController::class, 'create'])->name('task.create');
    Route::get('/task-editView/{taskId}', [TaskController::class, 'editView'])->name('task.editView');
    Route::put('/task-edit/{taskId}', [TaskController::class, 'edit'])->name('task.edit');
    Route::delete('/task-delete/{taskId}', [TaskController::class, 'delete'])->name('task.delete');

    Route::get('/task/api', [TaskController::class, 'api'])->name('task.api');
    Route::get('/task/api/user/{projectId}', [TaskController::class, 'apiGetUser'])->name('task.api.getUser');
});

