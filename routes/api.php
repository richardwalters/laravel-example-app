<?php

use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/users', function () {
    return UserResource::collection(User::all());
});

Route::get('/user/{id}', function (string $id) {
    return new UserResource(User::findOrFail($id));
});

// Laravel automatically injects dependencies like UserService
Route::apiResource('users_via_controller', UserController::class);
