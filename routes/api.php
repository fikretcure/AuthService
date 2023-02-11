<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
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

Route::name("users.store")->post("users", [UserController::class, "store"]);

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::name("users.")->prefix("users")->controller(UserController::class)->group(function () {
        Route::name("index")->get(null, "index");
        Route::name("show")->get("{id}", "show");
        Route::name("update")->put("{id}", "update");
        Route::name("destroy")->delete("{id}", "destroy");
    });

    Route::name("authentication.")->prefix("authentication")->controller(AuthenticationController::class)->group(function () {
        Route::name("login")->post("login", "login");
        Route::name("checkToken")->post("check-token", "checkToken")->withoutMiddleware(AuthMiddleware::class);
    });
});
