<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TaskController::class, 'index']);
Route::post("/task/new", [TaskController::class, 'store'])->name('newTask');
Route::post("/task/edit", [TaskController::class, 'edit'])->name('editTask');
Route::delete("/task/delete/{id}", [TaskController::class, 'destroy'])->name('deleteTask');
