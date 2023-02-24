<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassifiedController;
use App\Http\Controllers\FlyffapiItemController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::post('/users/{user}', [UserController::class, 'update']);
});

// Servers
Route::get('/servers', [ServerController::class, 'index']);

// items

// flyff items
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResources([
        'api-items' => 'FlyffapiItemController',
    ]);
});

// Classifieds
Route::post('/classified', [ClassifiedController::class, 'store'])->middleware('auth:sanctum');
Route::get('/classifieds', [ClassifiedController::class, 'index']);
Route::get('user/{user}/classifieds', [ClassifiedController::class, 'userClassifieds'])->middleware('auth:sanctum');
Route::delete('classified/{classified}', [ClassifiedController::class, 'destroy'])->middleware('auth:sanctum');
Route::put('classified/{classified}', [ClassifiedController::class, 'update'])->middleware('auth:sanctum');

// User
Route::get('users', [AdminController::class, 'users'])->middleware('auth:sanctum');
Route::delete('user/{user}', [AdminController::class, 'ban'])->middleware('auth:sanctum');
