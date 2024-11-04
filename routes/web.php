<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToDoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [TodoListController::class, 'welcome'])->name('ToDo');

Route::middleware(['auth:api'])->group(function () {
    Route::get('/todoList', [TodoListController::class, 'index']);
    Route::post('/todoList', [TodoListController::class, 'store']);
    // Add other routes as needed
});

