<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontController;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Apps\AppsController;

// Base Data
use App\Http\Controllers\Apps\Base\ContentController as BaseContentController;
use App\Http\Controllers\Apps\Base\GenderController as BaseGenderController;
use App\Http\Controllers\Apps\Base\LanguageController as BaseLanguageController;
use App\Http\Controllers\Apps\Base\LinkController as BaseLinkController;
use App\Http\Controllers\Apps\Base\RaceController as BaseRaceController;

// Master Data
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

        // Base Data
        Route::group(['prefix' => 'base'], function(){
            // Base data index
            Route::get('/', [AppsController::class, 'master'])->name('apps.base.index');

            // Base data content
            Route::get('content', [BaseContentController::class, 'index'])->name('apps.base.content.index');

            // Base data content - Add
            Route::get('content/add', [BaseContentController::class, 'add'])->name('apps.base.content.add');
            Route::post('content/add', [BaseContentController::class, 'addPost']);

            // Base data content - Accept & Decline
            Route::get('content/accept/{id}', [BaseContentController::class, 'accept'])->name('apps.base.content.accept');
            Route::get('content/decline/{id}', [BaseContentController::class, 'decline'])->name('apps.base.content.decline');

            // Base data gender
            Route::get('gender', [BaseGenderController::class, 'index'])->name('apps.base.gender.index');

            // Base data gender - Add
            Route::get('gender/add', [BaseGenderController::class, 'add'])->name('apps.base.gender.add');
            Route::post('gender/add', [BaseGenderController::class, 'addPost']);

            // Base data gender - Accept & Decline
            Route::get('gender/accept/{id}', [BaseGenderController::class, 'accept'])->name('apps.base.gender.accept');
            Route::get('gender/decline/{id}', [BaseGenderController::class, 'decline'])->name('apps.base.gender.decline');

            // Base data language
            Route::get('language', [BaseLanguageController::class, 'index'])->name('apps.base.language.index');

            // Base data language - Add
            Route::get('language/add', [BaseLanguageController::class, 'add'])->name('apps.base.language.add');
            Route::post('language/add', [BaseLanguageController::class, 'addPost']);

            // Base data language - Accept & Decline
            Route::get('language/accept/{id}', [BaseLanguageController::class, 'accept'])->name('apps.base.language.accept');
            Route::get('language/decline/{id}', [BaseLanguageController::class, 'decline'])->name('apps.base.language.decline');

            // Base data link
            Route::get('link', [BaseLinkController::class, 'index'])->name('apps.base.link.index');

            // Base data link - Add
            Route::get('link/add', [BaseLinkController::class, 'add'])->name('apps.base.link.add');
            Route::post('link/add', [BaseLinkController::class, 'addPost']);

            // Base data link - Accept & Decline
            Route::get('link/accept/{id}', [BaseLinkController::class, 'accept'])->name('apps.base.link.accept');
            Route::get('link/decline/{id}', [BaseLinkController::class, 'decline'])->name('apps.base.link.decline');

            // Base data race
            Route::get('race', [BaseRaceController::class, 'index'])->name('apps.base.race.index');

            // Base data race - Add
            Route::get('race/add', [BaseRaceController::class, 'add'])->name('apps.base.race.add');
            Route::post('race/add', [BaseRaceController::class, 'addPost']);

            // Base data race - Accept & Decline
            Route::get('race/accept/{id}', [BaseRaceController::class, 'accept'])->name('apps.base.race.accept');
            Route::get('race/decline/{id}', [BaseRaceController::class, 'decline'])->name('apps.base.race.decline');
        });

        // Master Data
        Route::group(['prefix' => 'master-data', 'middleware' => ['role:Admin']], function(){
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
