<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthorController;
use App\Http\Controllers\API\BookController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authors Routes
Route::apiResource('authors', AuthorController::class);

// Books Routes
Route::apiResource('books', BookController::class);

