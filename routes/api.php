<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::prefix('/agents')->group(function() {
    Route::get('/', [AgentController::class, 'index']);
    Route::post('/', [AgentController::class, 'create']);
    Route::get('/{id}', [AgentController::class, 'show']);
    Route::patch('/{id}', [AgentController::class, 'update']);
    Route::delete('/{id}', [AgentController::class, 'delete']);
});

Route::prefix('/customers')->group(function() {
    Route::get('/', [CustomerController::class, 'index']);
    Route::post('/', [CustomerController::class, 'create']);
    Route::get('/{id}', [CustomerController::class, 'show']);
    Route::patch('/{id}', [CustomerController::class, 'update']);
    Route::delete('/{id}', [CustomerController::class, 'delete']);
});
