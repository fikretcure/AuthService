<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
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

Route::name("authentication.")->prefix("authentication")->controller(AuthenticationController::class)->group(function () {
    Route::name("login")->post("login", "login");
    Route::name("checkToken")->post("check-token", "checkToken");
});

Route::apiResources([
    'users' => UserController::class
]);
