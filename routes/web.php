<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontController;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Apps\AppsController;

use App\Http\Controllers\Apps\MasterdataController;
use App\Http\Controllers\Apps\Master\UserController as MasterUserController;

Route::group(['prefix' => '/'], function(){
    // Index
    Route::get('/', [FrontController::class, 'index'])->name('index');

    // Auth
    Route::group(['prefix' => 'auth', 'middleware' => ['guest']], function(){
        // Register
        Route::get('register', [AuthController::class, 'register'])->name('register');
        Route::post('register', [AuthController::class, 'registerPost']);

        // Login
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('login', [AuthController::class, 'loginPost'])->middleware(['throttle:5,1']);

        // Recover
        Route::get('recover', [AuthController::class, 'recover'])->name('recover');
        Route::post('recover', [AuthController::class, 'recoverPost'])->middleware(['throttle:2,1']);

        // Reset
        Route::get('reset', [AuthController::class, 'reset'])->name('reset');
        Route::post('reset', [AuthController::class, 'resetPost']);

        // Verify
        Route::get('verify', [AuthController::class, 'verify'])->name('verify')->withoutMiddleware(['guest']);

        // Logout
        Route::get('logout', [AuthController::class, 'logout'])->name('logout')->withoutMiddleware(['guest']);
    });

    // App
    Route::group(['prefix' => 'apps', 'middleware' => ['auth']], function(){
        Route::get('/', [AppsController::class, 'index'])->name('apps.front.index');

        // Master Data
        Route::group(['prefix' => 'master-data'], function(){
            // Master data index
            Route::get('/', [AppsController::class, 'master'])->name('apps.master.index');

            // Master data user account
            Route::get('user-account', [MasterUserController::class, 'index'])->name('apps.master.user.index');

            // Master data user account - Add
            Route::get('user-account/add', [MasterUserController::class, 'add'])->name('apps.master.user.add');
            Route::post('user-account/add', [MasterUserController::class, 'addPost']);

            // Master data user account - Edit
            Route::get('user-account/edit/{id}', [MasterUserController::class, 'edit'])->name('apps.master.user.edit');
            Route::post('user-account/edit/{id}', [MasterUserController::class, 'editPost']);

            // Master data user account - Delete
            Route::get('user-account/delete/{id}', [MasterUserController::class, 'delete'])->name('apps.master.user.delete');
        });
    });
});
