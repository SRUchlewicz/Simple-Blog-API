<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\RegistrationController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ResetPasswordController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\PostAdminController;
use App\Http\Controllers\Api\V1\MediaController;
use App\Http\Controllers\Api\V1\UserController;

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

Route::prefix('v1')->group(function () {

    Route::post('register', [RegistrationController::class, 'register'])->name('Register');
    Route::post('login', [AuthController::class, 'login'])->name('Login');
    Route::post('forgot-password', [ResetPasswordController::class, 'forgotPassword'])->name('Forgot Password');
    Route::post('reset-password', [ResetPasswordController::class, 'resetPassword'])->name('Reset Password');
    Route::get('posts', [PostController::class, 'index'])->name('List Posts');
    Route::get('posts/{id}', [PostController::class, 'show'])->name('Show Post');
    
    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('Logout');
        
        Route::prefix('admin')->group(function () {
            Route::group(['middleware' => ['role:user,editor,admin']], function () {
                // currently users with role user do not have any permissions
            });
    
            Route::group(['middleware' => ['role:editor,admin']], function () {
                Route::get('posts', [PostAdminController::class, 'index']);
                Route::post('posts', [PostAdminController::class, 'store'])->name('Create Post');
                Route::get('posts/{id}', [PostAdminController::class, 'edit'])->name('Edit Post');
                Route::put('posts/{id}', [PostAdminController::class, 'update'])->name('Update Post');
                Route::delete('posts/{id}', [PostAdminController::class, 'destroy'])->name('Delete Post');
                Route::post('media/upload', [MediaController::class, 'upload'])->name('Upload Media');
            });
    
            Route::group(['middleware' => ['role:admin']], function () {
                Route::get('users', [UserController::class, 'index']);
                Route::post('users', [UserController::class, 'store'])->name('Create User');
                Route::get('users/{id}', [UserController::class, 'edit'])->name('Edit User');
                Route::put('users/{id}', [UserController::class, 'update'])->name('Update User');
                Route::delete('users/{id}', [UserController::class, 'destroy'])->name('Delete User');
                Route::post('users/role', [UserController::class, 'role'])->name('Change User Role');
            });
        });
    });
});

