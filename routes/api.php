<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/







use App\Http\Controllers\TodoListController;
use App\Http\Controllers\TaskController;


 // User CRUD routes
 Route::post('/auth/register', [AuthController::class, 'register']);
 Route::post('/auth/login', [AuthController::class, 'login']);

// To-do List CRUD routes
Route::middleware('auth:api')->group(function () {
    Route::get('/todo-lists', [TodoListController::class, 'index']); 
    Route::get('/todo-lists/{id}', [TodoListController::class, 'show']);
    Route::post('/todo-lists', [TodoListController::class, 'store']); 
    Route::put('/todo-lists/{id}', [TodoListController::class, 'update']);
    Route::delete('/todo-lists/{id}', [TodoListController::class, 'destroy']); 

    // Task CRUD routes within a specific to-do list
    Route::get('/todo-lists/{todoListId}/tasks', [TaskController::class, 'index']);
    Route::post('/todo-lists/{todoListId}/tasks', [TaskController::class, 'store']); 
    Route::get('/todo-lists/{todoListId}/tasks/{taskId}', [TaskController::class, 'show']);
    Route::put('/todo-lists/{todoListId}/tasks/{taskId}', [TaskController::class, 'update']);
    Route::delete('/todo-lists/{todoListId}/tasks/{taskId}', [TaskController::class, 'destroy']);
   

    Route::middleware(['jwt.auth'])->group(callback: function (): void {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::put('/user/update', [AuthController::class, 'update']); 
});


});