<?php

// Facades
use Illuminate\Support\Facades\Route;

// Redirect
use App\Http\Controllers\API\RedirectController;

// General
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Auth\AuthController;

// Apps
use App\Http\Controllers\Apps\AppsController;
use App\Http\Controllers\Apps\SimpingController as AppsSimpingController;

// Base Data
use App\Http\Controllers\Apps\Base\AffiliationController as BaseAffiliationController;
use App\Http\Controllers\Apps\Base\ContentController as BaseContentController;
use App\Http\Controllers\Apps\Base\GenderController as BaseGenderController;
use App\Http\Controllers\Apps\Base\LanguageController as BaseLanguageController;
use App\Http\Controllers\Apps\Base\LinkController as BaseLinkController;
use App\Http\Controllers\Apps\Base\ProxyHostController as BaseProxyHostController;
use App\Http\Controllers\Apps\Base\ProxyTypeController as BaseProxyTypeController;
use App\Http\Controllers\Apps\Base\RaceController as BaseRaceController;

// Manager
use App\Http\Controllers\Apps\Manager\FanboxController as ManagerFanboxController;
use App\Http\Controllers\Apps\Manager\FanboxSubmissionController as ManagerFanboxSubmissionController;
use App\Http\Controllers\Apps\Manager\UserController as ManagerUserController;

// Master Data
use App\Http\Controllers\Apps\Master\UserController as MasterUserController;

// Front
use App\Http\Controllers\Front\ContentController as FrontContentController;
use App\Http\Controllers\Front\CreatorController as FrontCreatorController;
use App\Http\Controllers\Front\FanboxController as FrontFanboxController;

// Debug
use App\Http\Controllers\Cron\BaseCron;
use App\Http\Controllers\Cron\TwitchCron;
use App\Http\Controllers\Cron\YoutubeCron;

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

        // 2FA
        Route::get('2fa', [AuthController::class, 'login2FA'])->name('2fa')->middleware(['signed'])->withoutMiddleware(['guest']);

        // Recover
        Route::get('recover', [AuthController::class, 'recover'])->name('recover');
        Route::post('recover', [AuthController::class, 'recoverPost'])->middleware(['throttle:2,1']);

        // Reset
        Route::get('reset', [AuthController::class, 'reset'])->name('reset')->middleware(['signed'])->withoutMiddleware(['guest']);
        Route::post('reset', [AuthController::class, 'resetPost'])->withoutMiddleware(['guest']);

        // Verify
        Route::group(['prefix' => 'verify', 'excluded_middleware' => ['guest']], function(){
            // Verify
            Route::get('/', [AuthController::class, 'verify'])->name('verify')->middleware(['signed']);

            // Resend Verify
            Route::get('resend', [AuthController::class, 'verifyResend'])->name('verify.resend');
            Route::post('resend', [AuthController::class, 'verifyResendPost'])->middleware(['throttle:2,1']);
        });

        // Claim
        Route::get('claim', [AuthController::class, 'claim'])->name('claim')->withoutMiddleware(['guest']);
        Route::post('claim', [AuthController::class, 'claimPost'])->withoutMiddleware(['guest']);

        // Logout
        Route::get('logout', [AuthController::class, 'logout'])->name('logout')->withoutMiddleware(['guest']);
    });

    // Creator
    Route::group(['prefix' => 'creator'], function(){
        // Index
        Route::get('/', [FrontCreatorController::class, 'index'])->name('creator.index');
        Route::post('/', [FrontCreatorController::class, 'indexSearch']);

        // Profile
        Route::get('{id}', [FrontCreatorController::class, 'profile'])->name('creator.profile');
        Route::post('{id}', [FrontCreatorController::class, 'profilePost']);

        // Claim
        Route::get('{id}/claim', [FrontCreatorController::class, 'claim'])->name('creator.claim');
        
        // >>>
        Route::get('{id}/claim/{ch}', [FrontCreatorController::class, 'claimVia'])->name('creator.claim.via');
        Route::post('{id}/claim/{ch}', [FrontCreatorController::class, 'claimViaPost'])->middleware(['throttle:2,60']);

        // Follow and Unfollow - Update Relationship
        Route::get('@{id}/rels', [FrontCreatorController::class, 'rels'])->name('creator.rels')->middleware(['auth', 'signed', 'throttle:100,60']);
    });

    // Content
    Route::group(['prefix' => 'content'], function(){
        // Live
        Route::get('live', [FrontContentController::class, 'live'])->name('content.live');

        // Scheduled
        Route::get('scheduled', [FrontContentController::class, 'scheduled'])->name('content.scheduled');

        // Archived
        Route::get('archived', [FrontContentController::class, 'archived'])->name('content.archived');

        // Archived
        Route::get('uploaded', [FrontContentController::class, 'uploaded'])->name('content.uploaded');

        // Setting
        Route::get('setting', [FrontContentController::class, 'setting'])->name('preference.content.setting');
        Route::post('setting', [FrontContentController::class, 'settingPost']);
    });

    // Fanbox
    Route::group(['prefix' => 'fanbox'], function(){
        // Index
        // Route::get('/', [FrontFanboxController::class, 'index'])->name('fanbox.index');

        // Add
        Route::get('{id}', [FrontFanboxController::class, 'answer'])->name('fanbox.answer');
        Route::post('{id}', [FrontFanboxController::class, 'answerPost']);

        // Edit
        Route::get('{id}/{did}', [FrontFanboxController::class, 'answerEdit'])->name('fanbox.answer.edit');
        Route::post('{id}/{did}', [FrontFanboxController::class, 'answerEditPost']);
    });

    // Apps
    Route::group(['prefix' => 'apps', 'middleware' => ['auth']], function(){
        // Apps Index
        Route::get('/', [AppsController::class, 'index'])->name('apps.front.index');

        // Apps Simping Routine
        Route::group(['prefix' => 'simp'], function(){
            // Index
            Route::get('/', [AppsSimpingController::class, 'index'])->name('apps.simp.index');
            Route::post('/', [AppsSimpingController::class, 'indexPost']);

            // Live
            Route::get('live', [AppsSimpingController::class, 'live'])->name('apps.simp.live');

            // Scheduled
            Route::get('scheduled', [AppsSimpingController::class, 'scheduled'])->name('apps.simp.scheduled');

            // Archived
            Route::get('archived', [AppsSimpingController::class, 'archived'])->name('apps.simp.archived');

            // Uploaded
            Route::get('uploaded', [AppsSimpingController::class, 'uploaded'])->name('apps.simp.uploaded');
        });

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

            // Email
            Route::get('email', [ManagerUserController::class, 'email'])->name('apps.usermenu.email');
            Route::post('email', [ManagerUserController::class, 'emailPost']);

            // Fanbox
            Route::group(['prefix' => 'fanbox'], function(){
                // Index
                Route::get('/', [ManagerFanboxController::class, 'index'])->name('apps.manager.fanbox.index');

                // Add
                Route::get('add', [ManagerFanboxController::class, 'add'])->name('apps.manager.fanbox.add');
                Route::post('add', [ManagerFanboxController::class, 'addPost']);

                // Edit
                Route::get('edit/{id}', [ManagerFanboxController::class, 'edit'])->name('apps.manager.fanbox.edit');
                Route::post('edit/{id}', [ManagerFanboxController::class, 'editPost']);

                // Delete
                Route::get('delete/{id}', [ManagerFanboxController::class, 'delete'])->name('apps.manager.fanbox.delete');

                // View
                Route::get('{id}', [ManagerFanboxSubmissionController::class, 'index'])->name('apps.manager.fanbox.view');

                // Delete
                Route::get('{id}/delete', [ManagerFanboxSubmissionController::class, 'delete'])->name('apps.manager.fanbox.delete-submission')->middleware(['signed']);
            });

            // Gender
            Route::get('gender', [ManagerUserController::class, 'gender'])->name('apps.manager.gender');
            Route::post('gender', [ManagerUserController::class, 'genderPost']);

            // Handler
            Route::get('handler', [ManagerUserController::class, 'handler'])->name('apps.manager.handler');
            Route::post('handler', [ManagerUserController::class, 'handlerPost']);

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
                Route::get('edit/{did}', [ManagerUserController::class, 'linkEdit'])->name('apps.manager.link.edit');
                Route::post('edit/{did}', [ManagerUserController::class, 'linkEditPost']);

                // Verify
                Route::get('verify/{did}', [ManagerUserController::class, 'linkVerify'])->name('apps.manager.link.verify');
                Route::post('verify/{did}', [ManagerUserController::class, 'linkVerifyPost'])->middleware(['throttle:2,60']);

                // Delete
                Route::get('delete/{did}', [ManagerUserController::class, 'linkDelete'])->name('apps.manager.link.delete');

                // Delete with Confirmation
                Route::get('delete/{did}/confirm', [ManagerUserController::class, 'linkDeleteConfirm'])->name('apps.manager.link.delete.confirm');
                Route::post('delete/{did}/confirm', [ManagerUserController::class, 'linkDeleteConfirmPost']);
            });

            // Password
            Route::get('password', [ManagerUserController::class, 'password'])->name('apps.usermenu.password');
            Route::post('password', [ManagerUserController::class, 'passwordPost']);

            // Persona
            Route::get('persona', [ManagerUserController::class, 'race'])->name('apps.manager.persona');
            Route::post('persona', [ManagerUserController::class, 'racePost']);
        });

        // Master Data - Need to be secured using Cloudflare Zerotrust
        Route::group(['prefix' => 'master-data', 'middleware' => ['role:Admin']], function(){
            // Master data index
            Route::get('/', [AppsController::class, 'master'])->name('apps.master.index');

            // Debug
            Route::group(['prefix' => 'debug'], function(){
                // Base
                Route::get('cron', [BaseCron::class, 'fetchDebug']);

                // General
                Route::get('general', [FrontController::class, 'fetchDebug']);
                
                // Twitch
                Route::get('twitch', [TwitchCron::class, 'fetchDebug']);
                
                // Youtube
                Route::get('youtube', [YoutubeCron::class, 'fetchDebug']);
            });

            // Master data - Base Affiliation
            Route::group(['prefix' => 'affiliation'], function(){
                // Index
                Route::get('/', [BaseAffiliationController::class, 'index'])->name('apps.base.affiliation.index');

                // Add
                Route::get('add', [BaseAffiliationController::class, 'add'])->name('apps.base.affiliation.add');
                Route::post('add', [BaseAffiliationController::class, 'addPost']);

                // Edit
                Route::get('edit/{id}', [BaseAffiliationController::class, 'edit'])->name('apps.base.affiliation.edit');
                Route::post('edit/{id}', [BaseAffiliationController::class, 'editPost']);

                // Decision
                Route::get('delete/{id}', [BaseAffiliationController::class, 'delete'])->name('apps.base.affiliation.delete');
            });

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

            // Master data - Base Persona-Race Type
            Route::group(['prefix' => 'persona-type'], function(){
                // Index
                Route::get('/', [BaseRaceController::class, 'index'])->name('apps.base.persona.index');

                // Add
                Route::get('add', [BaseRaceController::class, 'add'])->name('apps.base.persona.add');
                Route::post('add', [BaseRaceController::class, 'addPost']);

                // Edit
                Route::get('edit/{id}', [BaseRaceController::class, 'edit'])->name('apps.base.persona.edit');
                Route::post('edit/{id}', [BaseRaceController::class, 'editPost']);

                // Decision
                Route::get('delete/{id}', [BaseRaceController::class, 'delete'])->name('apps.base.persona.delete');
                Route::get('decision/{id}', [BaseRaceController::class, 'decision'])->name('apps.base.persona.decision');
            });

            // Master data - Base Proxy
            Route::group(['prefix' => 'proxy'], function(){
                // Master data - Base Proxy Type
                Route::group(['prefix' => 'type'], function(){
                    // Index
                    Route::get('/', [BaseProxyTypeController::class, 'index'])->name('apps.base.proxy.type.index');

                    // Add
                    Route::get('add', [BaseProxyTypeController::class, 'add'])->name('apps.base.proxy.type.add');
                    Route::post('add', [BaseProxyTypeController::class, 'addPost']);

                    // Edit
                    Route::get('edit/{id}', [BaseProxyTypeController::class, 'edit'])->name('apps.base.proxy.type.edit');
                    Route::post('edit/{id}', [BaseProxyTypeController::class, 'editPost']);

                    // Delete
                    Route::get('delete/{id}', [BaseProxyTypeController::class, 'delete'])->name('apps.base.proxy.type.delete');
                });

                // Master data - Base Proxy Host
                Route::group(['prefix' => 'host'], function(){
                    // Index
                    Route::get('/', [BaseProxyHostController::class, 'index'])->name('apps.base.proxy.host.index');

                    // MISC
                    Route::get('add', [BaseProxyHostController::class, 'add'])->name('apps.base.proxy.host.add');
                    Route::get('edit/{id}', [BaseProxyHostController::class, 'edit'])->name('apps.base.proxy.host.edit');
                    Route::get('delete/{id}', [BaseProxyHostController::class, 'edit'])->name('apps.base.proxy.host.delete');
                });
            });

            // Master data - User
            Route::group(['prefix' => 'user-account'], function(){
                // Index
                Route::get('/', [MasterUserController::class, 'index'])->name('apps.master.user.index');

                // Add
                Route::get('add', [MasterUserController::class, 'add'])->name('apps.master.user.add');
                Route::post('add', [MasterUserController::class, 'addPost']);

                // Manage User
                Route::group(['prefix' => '{uid}'], function(){
                    // Index
                    Route::get('/', [MasterUserController::class, 'manage'])->name('apps.master.user.manage.index');

                    // Biodata
                    Route::get('biodata', [MasterUserController::class, 'biodata'])->name('apps.master.user.manage.biodata');
                    Route::post('biodata', [MasterUserController::class, 'biodataPost']);

                    // Biodata
                    Route::get('affiliation', [MasterUserController::class, 'affiliation'])->name('apps.master.user.manage.affiliation');
                    Route::post('affiliation', [MasterUserController::class, 'affiliationPost']);

                    // Content
                    Route::get('content', [MasterUserController::class, 'content'])->name('apps.master.user.manage.content');
                    Route::post('content', [MasterUserController::class, 'contentPost']);

                    // Gender
                    Route::get('gender', [MasterUserController::class, 'gender'])->name('apps.master.user.manage.gender');
                    Route::post('gender', [MasterUserController::class, 'genderPost']);

                    // Gender
                    Route::get('language', [MasterUserController::class, 'language'])->name('apps.master.user.manage.language');
                    Route::post('language', [MasterUserController::class, 'languagePost']);

                    // Handler
                    Route::get('handler', [MasterUserController::class, 'handler'])->name('apps.master.user.manage.handler');
                    Route::post('handler', [MasterUserController::class, 'handlerPost']);

                    // Link
                    Route::group(['prefix' => 'link'], function(){
                        // Index
                        Route::get('/', [MasterUserController::class, 'link'])->name('apps.master.user.manage.link');
                        
                        // Add
                        Route::get('add', [MasterUserController::class, 'linkAdd'])->name('apps.master.user.manage.link.add');
                        Route::post('add', [MasterUserController::class, 'linkAddPost']);

                        // Edit
                        Route::get('edit/{did}', [MasterUserController::class, 'linkEdit'])->name('apps.master.user.manage.link.edit');
                        Route::post('edit/{did}', [MasterUserController::class, 'linkEditPost']);

                        // Verify
                        Route::get('verify/{did}', [MasterUserController::class, 'linkVerify'])->name('apps.master.user.manage.link.verify');
                        Route::post('verify/{did}', [MasterUserController::class, 'linkVerifyPost']);

                        // Delete
                        Route::get('delete/{did}', [MasterUserController::class, 'linkDelete'])->name('apps.master.user.manage.link.delete');

                        // Delete with Confirmation
                        Route::get('delete/{did}/confirm', [MasterUserController::class, 'linkDeleteConfirm'])->name('apps.master.user.manage.link.delete.confirm');
                        Route::post('delete/{did}/confirm', [MasterUserController::class, 'linkDeleteConfirmPost']);
                    });

                    // Persona
                    Route::get('persona', [MasterUserController::class, 'race'])->name('apps.master.user.manage.persona');
                    Route::post('persona', [MasterUserController::class, 'racePost']);
                });

                // Manage
                Route::get('{id}', [MasterUserController::class, 'edit'])->name('apps.master.user.manage');

                // Delete
                // Route::get('delete/{id}', [MasterUserController::class, 'delete'])->name('apps.master.user.delete');
            });
        });
    });

    // Redirect
    Route::group(['prefix' => 'go'], function(){
        // Index
        Route::get('/', [RedirectController::class, 'index'])->name('go.index');

        // Bsky
        Route::get('bsky', [RedirectController::class, 'bsky'])->name('go.bsky');

        // Twitter
        Route::get('twitter', [RedirectController::class, 'twitter'])->name('go.twitter');

        // Discord
        // TBA

        // Ping
        Route::get('ping', [RedirectController::class, 'ping'])->name('go.ping');

        // Status
        Route::get('status', [RedirectController::class, 'status'])->name('go.status');

        // Status
        Route::get('feedback', [RedirectController::class, 'feedback'])->name('go.feedback');

        // Status
        Route::get('cc-revision', [RedirectController::class, 'revision'])->name('go.revision');

        // Out
        Route::get('out', [RedirectController::class, 'outExt'])->name('go.out')->middleware(['signed']);
    });
});
