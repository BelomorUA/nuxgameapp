<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;

Route::get('/', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/user/{unique_link}', [UserController::class, 'show'])->name('user');
Route::post('/user/{unique_link}/generate', [UserController::class, 'generateNewLink'])->name('generate.new.link');
Route::post('/user/{unique_link}/deactivate', [UserController::class, 'deactivateLink'])->name('deactivate.link');
Route::post('/user/{unique_link}/feeling-lucky', [UserController::class, 'feelingLucky'])->name('feeling.lucky');
Route::post('/user/{unique_link}/history', [UserController::class, 'history'])->name('history');
