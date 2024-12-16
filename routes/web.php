<?php

use App\Http\Controllers\HomeController;
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

Route::get('/',[HomeController::class,'index']);
Route::controller(\App\Http\Controllers\UserController::class)->group(function () {
    Route::get('/login', 'login')->middleware('guest')->name('login');
    Route::post('/login', 'doLogin')->middleware('guest');
    Route::get('/register', [UserController::class,'register'])->middleware('guest');
    Route::post('register',[UserController::class,'doRegister'])->middleware('guest');
    Route::get('/logout', 'doLogout')->middleware('auth');
});

Route::controller(\App\Http\Controllers\TodolistController::class )
    ->middleware('auth')
    ->group(function () {
        Route::get('/todolist', 'todoList');
        Route::post('/todolist', 'addTodo');
        Route::post('/todolist/{id}/edit','editTodo');
        Route::post('/todolist/{id}/delete', 'removeTodo');
    });

Route::view('to', 'todolist.index');