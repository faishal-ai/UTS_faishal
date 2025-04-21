<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/',  [UserController::class, 'index']);

Route::group(['prefix' => 'user'], function() {
    Route::get('/',  [UserController::class, 'index']);
    Route::post('/data', [UserController::class, 'data']);
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/create', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    Route::put('/{id}/update', [UserController::class, 'update']);
    Route::put('/{id}/update', [UserController::class, 'update']);
    Route::get('{id}/delete', [UserController::class, 'confirm']);
    Route::delete('{id}/delete', [UserController::class, 'delete']);
});

Route::group(['prefix' => 'books'], function() {
    Route::get('/',  [BookController::class, 'index']);
    Route::get('/data', [BookController::class, 'data']);
    Route::get('/create', [BookController::class, 'create']);
    Route::post('/create', [BookController::class, 'store']);
    Route::get('/{id}', [BookController::class, 'show']);
    Route::get('/{id}/edit', [BookController::class, 'edit']);
    Route::put('/{id}/update', [BookController::class, 'update']);
    Route::put('/{id}/update', [BookController::class, 'update']);
    Route::get('{id}/delete', [BookController::class, 'confirm']);
    Route::delete('{id}/delete', [BookController::class, 'delete']);
});


Route::group(['prefix' => 'rentals'], function() {
    Route::get('/', [RentalController::class, 'index']);
    Route::get('/data', [RentalController::class, 'data']);
    Route::get('/create', [RentalController::class, 'create']);
    Route::post('/create', [RentalController::class, 'store']);
    Route::get('/{id}', [RentalController::class, 'show']);
    Route::get('/{id}/edit', [RentalController::class, 'edit']);
    Route::put('/{id}/update', [RentalController::class, 'update']);
    Route::get('/{id}/delete', [RentalController::class, 'confirm']);
    Route::delete('/{id}/delete', [RentalController::class, 'delete']);
});


