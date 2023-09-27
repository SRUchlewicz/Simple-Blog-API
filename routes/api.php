<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\RegistrationController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ResetPasswordController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::post('register', 'RegistrationController@register')->name('register.api');

// Public routes that don't require authentication
//Route::get('posts', 'PostController@index');
//Route::get('posts/{id}', 'PostController@show');
Route::prefix('v1')->group(function () {
    // Authentication routes
    Route::post('register', [RegistrationController::class, 'register'])->name('Register');
    Route::post('forgot-password', [ResetPasswordController::class, 'forgotPassword'])->name('Forgot Password');
    Route::post('reset-password', [ResetPasswordController::class, 'resetPassword'])->name('Reset Password');
    Route::post('login', [AuthController::class, 'login'])->name('Login');

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('Logout');

        // User actions
        //Route::get('me', 'AuthController@me');
        //Route::put('users/{id}', 'UserController@update');
        //Route::delete('users/{id}', 'UserController@delete');

        // Post actions for authenticated users
        //Route::post('posts', 'PostController@store');
        //Route::put('posts/{id}', 'PostController@update');
        //Route::delete('posts/{id}', 'PostController@destroy');

        // Any other routes that require authentication
    });
});

