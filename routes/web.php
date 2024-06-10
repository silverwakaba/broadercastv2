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

// Manager
use App\Http\Controllers\Apps\Manager\UserController as ManagerUserController;

// Master Data
use App\Http\Controllers\Apps\Master\UserController as MasterUserController;

// Front
use App\Http\Controllers\Front\CreatorController as FrontCreatorController;

// Debug | Please comment before deployment
use App\Http\Controllers\Cron\YoutubeCron;

Route::group(['prefix' => '/'], function(){
    // Index
    Route::get('/', [FrontController::class, 'index'])->name('index');

    // Debug
    Route::group(['prefix' => 'debug'], function(){
        Route::get('youtube', [YoutubeCron::class, 'fetchDebug']);
    });

    // Creator
    Route::group(['prefix' => 'creator'], function(){
        // Index
        Route::get('/', [FrontCreatorController::class, 'index'])->name('creator.index');

        // Profile
        Route::get('@{id}', [FrontCreatorController::class, 'profile'])->name('creator.profile');
    });

    // // Auth
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

    // Apps
    Route::group(['prefix' => 'apps', 'middleware' => ['auth']], function(){
        // Apps Index
        Route::get('/', [AppsController::class, 'index'])->name('apps.front.index');

        // Master data - Base Content Type
        Route::group(['prefix' => 'account-manager'], function(){
            // Index
            Route::get('/', [AppsController::class, 'manager'])->name('apps.manager.index');

            // Avatar
            Route::get('avatar', [ManagerUserController::class, 'avatar'])->name('apps.manager.avatar');
            Route::post('avatar', [ManagerUserController::class, 'avatarPost']);

            // Biodata
            Route::get('biodata', [ManagerUserController::class, 'biodata'])->name('apps.manager.biodata');
            Route::post('biodata', [ManagerUserController::class, 'biodataPost']);

            // Content
            Route::get('content', [ManagerUserController::class, 'content'])->name('apps.manager.content');
            Route::post('content', [ManagerUserController::class, 'contentPost']);

            // Gender
            Route::get('gender', [ManagerUserController::class, 'gender'])->name('apps.manager.gender');
            Route::post('gender', [ManagerUserController::class, 'genderPost']);

            // Language
            Route::get('language', [ManagerUserController::class, 'language'])->name('apps.manager.language');
            Route::post('language', [ManagerUserController::class, 'languagePost']);

            // Link
            Route::group(['prefix' => 'link'], function(){
                // Index
                Route::get('/', [ManagerUserController::class, 'link'])->name('apps.manager.link');
                
                // Add
                Route::get('add', [ManagerUserController::class, 'linkAdd'])->name('apps.manager.link.add');
                Route::post('add', [ManagerUserController::class, 'linkAddPost']);

                // Edit
                Route::get('edit/{id}', [ManagerUserController::class, 'linkEdit'])->name('apps.manager.link.edit');
                Route::post('edit/{id}', [ManagerUserController::class, 'linkEditPost']);

                // Verify
                Route::get('verify/{id}', [ManagerUserController::class, 'linkVerify'])->name('apps.manager.link.verify');
                Route::post('verify/{id}', [ManagerUserController::class, 'linkVerifyPost']);

                // Delete
                Route::get('delete/{id}', [ManagerUserController::class, 'linkDelete'])->name('apps.manager.link.delete');

                // Delete with Confirmation
                Route::get('delete/{id}/confirm', [ManagerUserController::class, 'linkDeleteConfirm'])->name('apps.manager.link.delete.confirm');
                Route::post('delete/{id}/confirm', [ManagerUserController::class, 'linkDeleteConfirmPost']);
            });

            // Race
            Route::get('race', [ManagerUserController::class, 'race'])->name('apps.manager.race');
            Route::post('race', [ManagerUserController::class, 'racePost']);
        });

        // Master Data
        Route::group(['prefix' => 'master-data', 'middleware' => ['role:Admin|Moderator']], function(){
            // Master data index
            Route::get('/', [AppsController::class, 'master'])->name('apps.master.index');

            // Master data - Base Content Type
            Route::group(['prefix' => 'content-type'], function(){
                // Index
                Route::get('/', [BaseContentController::class, 'index'])->name('apps.base.content.index');

                // Add
                Route::get('add', [BaseContentController::class, 'add'])->name('apps.base.content.add');
                Route::post('add', [BaseContentController::class, 'addPost']);

                // Edit
                Route::get('edit/{id}', [BaseContentController::class, 'edit'])->name('apps.base.content.edit');
                Route::post('edit/{id}', [BaseContentController::class, 'editPost']);

                // Decision
                Route::get('delete/{id}', [BaseContentController::class, 'delete'])->name('apps.base.content.delete');
                Route::get('decision/{id}', [BaseContentController::class, 'decision'])->name('apps.base.content.decision');
            });

            // Master data - Base Gender Type
            Route::group(['prefix' => 'gender-type'], function(){
                // Index
                Route::get('/', [BaseGenderController::class, 'index'])->name('apps.base.gender.index');

                // Add
                Route::get('add', [BaseGenderController::class, 'add'])->name('apps.base.gender.add');
                Route::post('add', [BaseGenderController::class, 'addPost']);

                // Edit
                Route::get('edit/{id}', [BaseGenderController::class, 'edit'])->name('apps.base.gender.edit');
                Route::post('edit/{id}', [BaseGenderController::class, 'editPost']);

                // Decision
                Route::get('delete/{id}', [BaseGenderController::class, 'delete'])->name('apps.base.gender.delete');
                Route::get('gender/decision/{id}', [BaseGenderController::class, 'decision'])->name('apps.base.gender.decision');
            });

            // Master data - Base Language Type
            Route::group(['prefix' => 'language-type'], function(){
                // Index
                Route::get('/', [BaseLanguageController::class, 'index'])->name('apps.base.language.index');

                // Add
                Route::get('add', [BaseLanguageController::class, 'add'])->name('apps.base.language.add');
                Route::post('add', [BaseLanguageController::class, 'addPost']);

                // Edit
                Route::get('edit/{id}', [BaseLanguageController::class, 'edit'])->name('apps.base.language.edit');
                Route::post('edit/{id}', [BaseLanguageController::class, 'editPost']);

                // Decision
                Route::get('delete/{id}', [BaseLanguageController::class, 'delete'])->name('apps.base.language.delete');
                Route::get('decision/{id}', [BaseLanguageController::class, 'decision'])->name('apps.base.language.decision');
            });

            // Master data - Base Link Type
            Route::group(['prefix' => 'link-type'], function(){
                // Index
                Route::get('/', [BaseLinkController::class, 'index'])->name('apps.base.link.index');

                // Add
                Route::get('add', [BaseLinkController::class, 'add'])->name('apps.base.link.add');
                Route::post('add', [BaseLinkController::class, 'addPost']);

                // Edit
                Route::get('edit/{id}', [BaseLinkController::class, 'edit'])->name('apps.base.link.edit');
                Route::post('edit/{id}', [BaseLinkController::class, 'editPost']);

                // Decision
                Route::get('delete/{id}', [BaseLinkController::class, 'delete'])->name('apps.base.link.delete');
                Route::get('decision/{id}', [BaseLinkController::class, 'decision'])->name('apps.base.link.decision');
            });

            // Master data - Base Race Type
            Route::group(['prefix' => 'race-type'], function(){
                // Index
                Route::get('/', [BaseRaceController::class, 'index'])->name('apps.base.race.index');

                // Add
                Route::get('add', [BaseRaceController::class, 'add'])->name('apps.base.race.add');
                Route::post('add', [BaseRaceController::class, 'addPost']);

                // Edit
                Route::get('edit/{id}', [BaseRaceController::class, 'edit'])->name('apps.base.race.edit');
                Route::post('edit/{id}', [BaseRaceController::class, 'editPost']);

                // Decision
                Route::get('delete/{id}', [BaseRaceController::class, 'delete'])->name('apps.base.race.delete');
                Route::get('decision/{id}', [BaseRaceController::class, 'decision'])->name('apps.base.race.decision');
            });

            // Master data - User
            Route::group(['prefix' => 'user-account'], function(){
                // Index
                Route::get('/', [MasterUserController::class, 'index'])->name('apps.master.user.index');

                // Add
                Route::get('add', [MasterUserController::class, 'add'])->name('apps.master.user.add');
                Route::post('add', [MasterUserController::class, 'addPost']);

                // Edit
                Route::get('edit/{id}', [MasterUserController::class, 'edit'])->name('apps.master.user.edit');
                Route::post('edit/{id}', [MasterUserController::class, 'editPost']);

                // Delete
                Route::get('delete/{id}', [MasterUserController::class, 'delete'])->name('apps.master.user.delete');
            });
        });
    });
});
